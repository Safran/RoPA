<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Backend;

use App\Jobs\PublishNewFormVersion;
use App\Models\CommentTemplate;
use App\Models\Form;
use App\Models\StatementTemplateAnswer;
use App\Models\Transformers\JobStatusTransformer;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Imtigger\LaravelJobStatus\JobStatus;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Class FormController
 *
 * @package App\Http\Controllers\Backend
 */
class FormController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$forms = Form::latest()->get();

		return view('backend.forms.index', compact('forms'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$current = Form::Current();

		// Count drafts
		if (Form::whereNull('published_at')->count() > 0)
		{
			abort('403');
		}
		if ( ! $current)
		{
			$form = new Form;
			$form->setTranslations('title', [ 'fr' => 'Formulaire initial', 'en' => 'Initial Form' ]);

			$form->published_at = null;
			$form->published_by = null;
			$form->created_by   = auth()->user()->id;
			if ($form->save())
			{
				return redirect(route('admin.forms'))->with('success', __('admin/forms.created-successful'));
			}
			else
			{
				abort(500);
			}
		}

		$form     = $current->replicate();
		$newtitle = [];
		foreach (locales() as $locale)
		{
			$title   = $form->getTranslation('title', $locale);
			$matches = [];
			$number  = 1;
			if (preg_match("/^(.*)\s+-\s+(\d+)$/", $title, $matches))
			{
				$title  = $matches[1];
				$number = ( $matches[2] + 1 );
			}
			$newtitle[$locale] = $title . ' - ' . $number;
		}
		$form->setTranslations('title', $newtitle);
		$form->published_at = null;
		$form->published_by = null;
		$form->created_by   = auth()->user()->id;

		if ($form->save())
		{
			$ne = collect();
			foreach ($form->pages as $page)
			{
				$newpage          = $page->replicate();
				$newpage->form_id = $form->id;
				$newpage->save();

				foreach ($page->elements as $element)
				{
					$newelement          = $element->replicate();
					$newelement->page_id = $newpage->id;
					$newelement->save();
					$ne[$element->id] = $newelement;

					if ($element->commenttemplates)
					{
						foreach ($element->commenttemplates as $template)
						{
							$template->form_element_id = $newelement->id;
							$template->save();
						}
					}
				}
			}

			// Resync elements showing rules
			foreach ($current->elements as $element)
			{
				if ($element->element_show_if->count() > 0)
				{
					$newelement = $ne[$element->id];
					if ($newelement)
					{
                        $element->element_show_if->each(function($oldelement) use($form, $newelement) {
                            $element = $form->elements()->where('name', $oldelement->name)->firstOrFail();
                            $newelement->element_show_if()->attach(  [$element->id => [ 'if_element_value' => $oldelement->pivot->if_element_value ]]   );
                        });
					}
				}
			}
			return redirect(route('admin.forms'))->with('success', __('admin/forms.created-successful'));
		}

		return redirect(route('admin.forms'))->with('error', __('admin/forms.created-failed'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Form $form
	 *
	 * @return \Illuminate\Http\Response
	 * @throws AuthorizationException
	 */
	public function edit(Form $form)
	{
		if (\App::environment([ 'production', 'staging' ]))
		{
			// In production mode, we don't allow editing form to avoid
			// weird side effects
			if ($form->is_published)
			{
				throw new AuthorizationException('form is published');
			}
		}

		return view('backend.forms.edit', compact('form'));

	}


	/**
	 * @param Form $form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getModalDelete(Form $form)
	{
		$model         = 'forms.form';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.forms.delete', [ $form ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/forms.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 * @param Form $form
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Form $form)
	{
		if ( ! $form->published_at)
		{
			$form->forceDelete();

			return redirect(route('admin.forms'))->with('success', __('admin/forms.deleted-successful'));
		}
		abort(403);
	}


	/**
	 *
	 * @param Form $form
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function publish(Form $form)
	{
		if ( ! $form->published_at)
		{
			$me = auth()->user();
			$form->published_at = Carbon::now();
			$form->published_by = $me->id;

			// Rellocate all template answers
			$newelements = collect();

			StatementTemplateAnswer::each(function ($statementTemplateAnswer) use ($form, $newelements) {
				if(! $newelements->has($statementTemplateAnswer->element->name))
				{
					$newelements[$statementTemplateAnswer->element->name] = $form->elements->where('name', $statementTemplateAnswer->element->name)->first();
				}
				$newelement = $newelements[$statementTemplateAnswer->element->name];
				if ($newelement)
				{
					$statementTemplateAnswer->form_element_id = $newelement->id;
					$statementTemplateAnswer->save();
				}
				else
				{
					$statementTemplateAnswer->delete();
				}
			});

			// Rellocate all template comments
			CommentTemplate::each(function ($commentTemplate) use ($form, $newelements) {
				if(! $newelements->has($commentTemplate->element->name))
				{
					$newelements[$commentTemplate->element->name] = $form->elements->where('name', $commentTemplate->element->name)->first();
				}
				$newelement = $newelements[$commentTemplate->element->name];
				if ($newelement)
				{
					$commentTemplate->form_element_id = $newelement->id;
					$commentTemplate->save();
				}
				else
				{
					$commentTemplate->delete();
				}
			});

			$form->save();

			\Cache::flush();
			return redirect(route('admin.forms'))->with('success', __('admin/forms.published-successful'));
		}

		return redirect(route('admin.forms'))->with('error', __('admin/forms.published-error'));
	}


	/**
	 * @param $id
	 *
	 * @return \Spatie\Fractal\Fractal
	 */
	public function getPublishStatus($id)
	{
		$jobStatus = JobStatus::find($id);

		return fractal($jobStatus, new JobStatusTransformer, new ArraySerializer);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Form         $form
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Form $form)
	{
		$this->updateTranslations($form, $request);
		$request->merge([ 'modified_by' => auth()->id() ]);
		if ($form->update($request->except(array_merge($form->getTranslatableAttributes(), [ '_method', '_token' ]))))
		{
			return redirect(route('admin.forms.edit', [ $form ]))->with('success',
				trans('admin/commons.message.success.update'));
		}
		else
		{
			return redirect(route('admin.forms.edit', [ $form ]))->withInput()->with('error',
				trans('admin/commons.message.error.update'));
		}
	}
}
