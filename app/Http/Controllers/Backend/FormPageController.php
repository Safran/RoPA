<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use App\Http\Requests\PageRequest;
use App\Models\Form;
use App\Models\FormPage;
use Illuminate\Http\Request;

/**
 * Class FormPageController
 *
 * @package App\Http\Controllers\Backend
 */
class FormPageController extends Controller
{
	/**
	 *
	 * @param Form $form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(Form $form)
	{
		return view('backend.pages.create', compact('form'));
	}


	/**
	 *
	 * @param PageRequest $request
	 * @param Form        $form
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(PageRequest $request,  Form $form)
	{
		//$this->authorize('manage', $form);

		$page = new FormPage;
		$page->form()->associate($form);
		$page->setTranslations('title', $request->get('title'));
		$page->setTranslations('disclaimer', $request->get('disclaimer'));
		$page->created_by = auth()->id();

		$page->save();
		if ($page->id)
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->with('success',
				trans('admin/commons.messages.success.create', [ 'element' => __('admin/forms.page.title') ]));
		}
		else
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->withInput()->with('error',
				trans('admin/commons.messages.success.create', [ 'element' => __('admin/forms.page.title') ]));
		}
	}


	/**
	 *
	 * @param Form     $form
	 * @param FormPage $formPage
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Form $form, FormPage $formPage)
	{
		return view('backend.pages.edit', compact('form', 'formPage'));
	}


	/**
	 *
	 * @param Request  $request
	 * @param Form     $form
	 * @param FormPage $formPage
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request,  Form $form, FormPage $formPage)
	{
		//$this->authorize('manage', $form);

		$this->updateTranslations($formPage, $request);

		$request->merge([ 'modified_by' => auth()->id() ]);
		if ($formPage->update($request->except(array_merge($formPage->getTranslatableAttributes(),
			[ '_method', '_token' ]))))
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->with('success',
				trans('admin/commons.messages.success.update', [ 'element' => __('admin/forms.page.title') ]));
		}
		else
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->withInput()->with('error',
				trans('admin/commons.messages.error.update', [ 'element' => __('admin/forms.page.title') ]));
		}
	}


	/**
	 * Saving order
	 */
	public function saveOrder()
	{
		FormPage::setNewOrder(request('ids'));
	}


	/**
	 *
	 * @param Form     $form
	 * @param FormPage $formPage
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getModalDelete(Form $form, FormPage $formPage)
	{
		$model         = 'forms.formpage';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.pages.delete', [ $form, $formPage ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/forms.page.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 *
	 * @param Form     $form
	 * @param FormPage $formPage
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Form $form, FormPage $formPage)
	{
		if ($formPage->delete())
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/forms.page.title') ]));
		}
		else
		{
			return redirect(route('admin.forms.edit', [ $form ]) . '#pages')->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/forms.page.title') ]));
		}
	}
}
