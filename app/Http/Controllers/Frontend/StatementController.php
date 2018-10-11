<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Frontend;

use App\Events\StatementCreated;
use App\Events\StatementSupervised;
use App\Events\StatementUpdated;
use App\Events\StatementValidated;
use App\Exports\AnswersExport;
use App\Exports\StatementsExport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\StatementRepository;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Form;
use App\Models\Statement;
use App\Models\Transformers\FormTransformer;
use App\Models\Transformers\StatementTransformer;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Fractalistic\ArraySerializer;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

/**
 * Class StatementController
 *
 * @package App\Http\Controllers\Frontend
 */
class StatementController extends Controller
{

	/**
	 * @var StatementRepository
	 */
	protected $repository;


	/**
	 * StatementController constructor.
	 *
	 * @param StatementRepository $repository
	 */
	public function __construct(StatementRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function disclaimer()
	{
		$form = Form::current();

		$pages = collect(explode('<div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>',
			$form->disclaimer));

		return view('frontend.disclaimer', compact('pages'));
	}


	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function seen()
	{
		$me = auth()->user();

		$me->seen()->create([ 'seen_at' => Carbon::now() ]);

		return response(json_encode([ 'redirect' => route('frontend.statements.create') ]), 200);
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		$form = Form::current();
		if ( ! $form)
		{
			die('no form published yet');
		}

		return view('frontend.statements.create', compact('form'));
	}


	/**
	 * @param Statement $statement
	 * @param           $uuid
	 *
	 * @return mixed
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function showFile(Statement $statement, $uuid)
	{
		$this->authorize('edit', $statement);

		// Get file type from the form
		$files = $statement->form->elements->filter(function ($element) {
			return $element->type == 'file';
		});

		foreach ($files as $file)
		{
			$answer = $statement->get($file->name);

			if ($answer && $answer->uuid === $uuid)
			{
				// Now load
				return response()->file(storage_path('private/' . $answer->path));
			}
		}

		abort(404);
	}


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		// Reformat request
		$this->reformatSerializerRequest($request);

		// Build validation
		$form     = Form::current();
		$rules    = $form->getValidationsRules(collect($request->all()))->toArray();
		$messages = [];
		foreach ($form->elements as $element)
		{
			$messages[$element->name . '.required'] = __('statements.field-required');
		}
		$request->validate($rules, $messages);

		\Cache::flush();

		$supervisor_id = null;
		try
		{
			$company       = Company::findOrFail($request->company);
			$supervisor_id = $company->lawyer_id;
			User::findOrFail($supervisor_id);
		}
		catch (\Exception $e)
		{
            $supervisor_id = null;
		}

		$statement = Statement::create([
			'form_id'       => $form->id,
			'created_by'    => auth()->user()->id,
			'owner_id'      => $request->user,
			'supervisor_id' => $supervisor_id,
		]);

		foreach ($form->pages as $page)
		{
			foreach ($page->elements as $element)
			{
				if ($request->has($element->name))
				{
					$value = $request->{$element->name};
				}
				$default = $element->getDefaultValue();

				if ($element->type == 'file')
				{
					$value = $this->manageFile($request, $statement, $element->name);
				}

				Answer::create([
					'form_element_id' => $element->id,
					'statement_id'    => $statement->id,
					'answer'          => ( $value !== null ) ? serialize($value) : serialize($default),
					'created_by'      => auth()->user()->id,
				]);
			}
		}
		event(new StatementCreated($statement));

		return response([ 'id' => $statement->id ], 201);

		//return redirect(route('frontend.statements.inprogress'))->with('ok', __('statements.saved'));
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function pendings()
	{
		// Employee can't manage pendings statements
		$this->authorize('manage', Statement::class);

		$companies = Company::has('users.statements')->pluck('name', 'id');
		$pendings  = $this->repository->getPendingFilteredQuery();

		$countries = $this->prepareStatements($pendings);
		$countries = $countries->pluck('name', 'id');

		return view('frontend.statements.pendings', compact('pendings', 'companies', 'countries'));
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function inprogress()
	{
		$companies  = Company::has('users.statements')->pluck('name', 'id');
		$inprogress = $this->repository->getInprogressFilteredQuery(false, 0);

		$countries = $this->prepareStatements($inprogress);
		$countries = $countries->pluck('name', 'id');

		return view('frontend.statements.inprogress', compact('inprogress', 'companies', 'countries'));
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function finished()
	{
		$companies = Company::has('users.statements')->pluck('name', 'id');
		$finished  = $this->repository->getFinishedFilteredQuery();

		$countries = $this->prepareStatements($finished);
		$countries = $countries->pluck('name', 'id');

		return view('frontend.statements.finished', compact('finished', 'companies', 'countries'));
	}


	/**
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function edit(Statement $statement)
	{
		$this->authorize('edit', $statement);

		// Check statement is according to current form
		if(($statement->form_id != Form::current()->id) && !$statement->validated)
		{
			return redirect(route('frontend.statements.upgrade', [ $statement ]));
		}

		return view('frontend.statements.edit', compact('statement'));
	}


	/**
	 *
	 * @param Statement $statement
	 */
	public function upgrade(Statement $statement)
	{
		if($statement->validated)
		{
			abort(403);
		}
		// New form version
		$form = Form::current();
		$statement->form->elements->each(function ($element) use ($form, $statement) {
			$newelement = $form->elements->where('name', $element->name)->first();
			if ($newelement)
			{
				// Relocate form element for each answers to the new ones for this statement
				$element->answers->where('statement_id', $statement->id)->each(function ($answer) use ($newelement) {
					$answer->form_element_id = $newelement->id;
					$answer->save();
				});
			}
			else
			{
				// Element form has been removed. No need to keep answers
				$element->answers()->delete();
			}
		});

		$statement->form_id = $form->id;
		$statement->save();

		Cache::flush();

		return redirect(route('frontend.statements.edit', [ $statement ]))->with('success', __('statements.upgraded'));
	}


	public function manageFile(Request $request, Statement $statement, $name)
	{
		if ($request->hasFile($name))
		{
			$uploaded = $request->file($name);

			if ($uploaded->isValid())
			{
				// Prepare folder
				if ( ! File::exists(storage_path('private')))
				{
					File::makeDirectory(storage_path('private'));
				}
				if ( ! File::exists(storage_path('private/' . $statement->id . '/')))
				{
					File::makeDirectory(storage_path('private/' . $statement->id . '/'));
				}

				// Check old file
				$old = $statement->get($name);

				// Store file
				$path = $uploaded->store($statement->id, [ 'disk' => 'private' ]);

				$guesser         = new MimeTypeExtensionGuesser;
				$att             = new \stdClass;
				$att->uuid       = \Uuid::generate()->string;
				$att->path       = $path;
				$att->md5        = md5($uploaded->getClientSize());
				$att->created_by = auth()->user()->id;
				$att->name       = $uploaded->getClientOriginalName();
				$att->type       = $uploaded->getMimeType();
				$att->size       = $uploaded->getSize();
				$att->mime       = $guesser->guess($att->type);
				$att->link       = route('frontend.private.show', [ $statement, $att->uuid ]);

				if ($old)
				{
					Log::debug("deleting [" . $old->path . "]");
					Storage::disk('private')->delete($old->path);
				}

				return $att;
			}
		}

		return null;
	}


	/**
	 *
	 * @param Request $request
	 */
	protected function reformatSerializerRequest(Request $request)
	{
		$input = $request->input();
		foreach ($input as $key => $value)
		{
			try
			{
				$input[$key] = unserialize($value);
                if(strpos($input[$key], '<br>'))
                {
                    $input[$key] = preg_replace('/<br>/', "\r\n", $input[$key]);
                }
			}
			catch (\Exception $e)
			{
				// If we can't, don't change it
			}
		}
		$request->replace($input);
	}


	/**
	 * @param Request   $request
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \App\Form\Exceptions\FieldTypeDoesNotExists
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function update(Request $request, Statement $statement)
	{
		/** check rights ! @see \App\Policies\StatementPolicy */
		$this->authorize('edit', $statement);

		// Build validation
		$form = Form::current();

		// Reformat request
		$this->reformatSerializerRequest($request);

		$rules = $form->getValidationsRules($statement->getAnswers())->toArray();

		$messages = [];
		foreach ($form->elements as $element)
		{
			$messages[$element->name . '.required'] = __('statements.field-required');
		}
		$request->validate($rules, $messages);

		\Cache::flush();

		$statement->update([
			'modified_by' => auth()->user()->id,
			'owner_id'    => $request->user,
		]);

		foreach ($form->elements as $element)
		{
			$answer = $element->answer($statement)->first();

			$value = $request->{$element->name};

			if ($element->type == 'file')
			{
				$value = $this->manageFile($request, $statement, $element->name);
			}

			if ( ! isset($answer))
			{
				if ( ! isset($answer->validated_at))
				{
					Answer::create([
						'form_element_id' => $element->id,
						'statement_id'    => $statement->id,
						'answer'          => serialize($value),
						'created_by'      => auth()->user()->id,
					]);
				}
				else
				{
					continue; // validated field no update possible
				}
			}
			else
			{
                if ($element->type != 'file' || isset($value))
                {
                    $answer->answer = serialize($value);
                    $answer->save();
                }

				// clear Cache
				\Cache::forget('answer-' . $statement->id . '-' . $element->name);
				\Cache::forget('answer-as-string-' . $statement->id . '-' . $element->name);
			}

		}

		\Cache::forget('statement-' . $statement->id . '-progress');
		\Cache::forget('statements-answers-' . $statement->id);

		$me = auth()->user();
		event(new StatementUpdated($statement, $me));

		return response([], 204);

		//return redirect(route('frontend.statements.edit', [ $statement ]))->with('ok', __('statements.updated'));
	}


	/**
	 * @param Request   $request
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function supervise(Request $request, Statement $statement)
	{
		$this->authorize('manage', $statement);

		$me = auth()->user();
		if ($me->role == 'admin')
		{
			$statement->supervisor_id = $request->get('id');
		}
		else
		{
			$statement->supervisor_id = auth()->user()->id;
		}
		if ($statement->save())
		{
			\Cache::flush();

			event(new StatementSupervised($statement, $me));

			return response(json_encode([]), 204);
		}
		else
		{
			return response(json_encode([]), 500);
		}
	}


	/**
	 *
	 * @param Request   $request
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function creator(Request $request, Statement $statement)
	{
		$this->authorize('changeCreator', $statement);

		$statement->created_by = $request->get('id');
		if ($statement->save())
		{
			\Cache::flush();

			return response(json_encode([]), 204);
		}
		else
		{
			return response(json_encode([]), 500);
		}
	}


	/**
	 * User validate its completed declaration
	 *
	 * @param Request   $request
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function validateIt(Request $request, Statement $statement)
	{
		$this->authorize('validate', $statement);

		if ($statement->progress['global'] == 100 && ! $statement->validated)
		{
			$statement->validated = true;
			$statement->save();
			$me = auth()->user();
			event(new StatementValidated($statement, $me));
			\Cache::flush();
		}
		else
		{
			return response(json_encode([ 'error' => 'can\'t validate' ]), 400);
		}

		return response([], 204);
	}


	/**
	 *
	 * @param Request   $request
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function archivate(Request $request, Statement $statement)
	{
		$this->authorize('manage', $statement);

		if ($statement->progress['global'] == 100 && $statement->validated && ! $statement->archived)
		{
			$statement->archived = true;
			$statement->save();
			\Cache::flush();
		}
		else
		{
			return response(json_encode([ 'error' => 'can\'t archivate' ]), 400);
		}

		return response([], 204);
	}


	/**
	 *
	 * @return $this
	 */
	public function form()
	{
		$form = Form::current();

		return fractal($form, new FormTransformer, new ArraySerializer)->parseIncludes('pages.elements.answer');
	}


	/**
	 *
	 * @param Statement $statement
	 *
	 * @return $this
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function data(Statement $statement)
	{
		$this->authorize('edit', $statement);

		return fractal($statement, new StatementTransformer, new ArraySerializer)->parseIncludes(['pages', 'pages.elements.answer', 'pages.elements.commenttemplates', ]);
	}


	/**
	 *
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function exportAnswers(Statement $statement)
	{
		return ( new AnswersExport($statement) )->download();
	}


	/**
	 * Export- table in CSV
	 *
	 * @param string $type
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function exportCSV($type = 'inprogress')
	{
		if ( ! in_array($type, [ 'inprogress', 'finished', 'pending' ]))
		{
			abort(403);
		}

		return ( new StatementsExport($type) )->download();
	}


	/**
	 * Duplicate a statement
	 *
	 * @param Statement $statement
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function duplicate(Statement $statement)
	{
		$this->authorize('duplicate', $statement);

		$form           = Form::current();
		$new            = $statement->replicate();
		$new->form_id   = $form->id;
		$new->validated = false;
		$new->archived  = false;
		if ($new->save())
		{

			foreach ($form->elements as $element)
			{
				$answer = $element->answer($statement)->first();
				Answer::create([
					'form_element_id' => $element->id,
					'statement_id'    => $new->id,
					'answer'          => isset($answer) ? $answer->answer : serialize($default),
					'created_by'      => auth()->user()->id,
					'validated_at'    => null,
				]);
			}
		}
		flash()->overlay(__('statements.duplicated'));

		return redirect(route('frontend.statements.edit', [ $new ]))->with('success', __('statements.duplicated'));
	}


}
