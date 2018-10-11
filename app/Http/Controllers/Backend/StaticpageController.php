<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use App\Http\Requests\StaticpageRequest;
use App\Models\Staticpage;

/**
 * Class StaticpageController
 *
 * @package App\Http\Controllers\Backend
 */
class StaticpageController extends Controller
{
	public function index()
	{
		$pages = Staticpage::all();

		return view('backend.staticpages.index', compact('pages'));
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		return view('backend.staticpages.create');
	}


	/**
	 *
	 * @param StaticpageRequest $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function store(StaticpageRequest $request)
	{
		//$this->authorize('manage', $form);

		$staticpage = Staticpage::create([
			'created_by' => auth()->id(),
			'slug'       => request('slug'),
			'title'      => request('title'),
			'body'       => request('body')
		]);

		if (request()->wantsJson())
		{
			return response($staticpage, 201);
		}

		if ($staticpage->id)
		{
			return redirect(route('admin.staticpages'))->with('success',
				trans('admin/commons.messages.success.create', [ 'element' => __('admin/staticpages.title') ]));
		}
		else
		{
			return redirect(route('admin.staticpages'))->withInput()->with('error',
				trans('admin/commons.messages.error.create', [ 'element' => __('admin/staticpages.title') ]));
		}
	}


	/**
	 *
	 * @param Staticpage $staticpage
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Staticpage $staticpage)
	{
		return view('backend.staticpages.edit', compact('staticpage'));
	}


	/**
	 *
	 * @param StaticpageRequest $request
	 * @param Staticpage        $staticpage
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(StaticpageRequest $request, Staticpage $staticpage)
	{
		//$this->authorize('manage', $form);

		$request->merge([ 'modified_by' => auth()->id() ]);

		if ($staticpage->update($request->all()))
		{
			return redirect(route('admin.staticpages'))->with('success', trans('admin/commons.messages.success.update', ['element' => __('admin/staticpages.title')]));
		}
		else
		{
			return redirect(route('admin.staticpages'))->withInput()->with('error', trans('admin/commons.messages.error.update', ['element' => __('admin/staticpages.title')]));
		}

	}

	/**
	 *
	 * @param Staticpage $staticpage
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getModalDelete(Staticpage $staticpage)
	{
		$model         = 'staticpages';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.staticpages.delete', [ $staticpage ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/staticpages.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 *
	 * @param Staticpage $staticpage
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Staticpage $staticpage)
	{
		if ($staticpage->delete())
		{
			return redirect(route('admin.staticpages'))->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/staticpages.title') ]));
		}
		else
		{
			return redirect(route('admin.staticpages'))->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/staticpages.title') ]));
		}
	}
}
