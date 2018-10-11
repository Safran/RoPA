<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

/**
 *
 * Class MenuController
 * @package App\Http\Controllers\Backend
 */
class MenuController extends Controller
{

	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
    	$menus = Menu::all();
        return view('backend.menus.index', compact('menus'));
    }


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function create()
    {
	    return view('backend.menus.create');
    }


	/**
	 * @param MenuRequest $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function store(MenuRequest $request)
    {

	    //$this->authorize('manage', $form);

	    $menu = Menu::create([
		    'created_by' => auth()->id(),
		    'slug'       => $request->get('slug'),
		    'title'      =>  $request->get('title'),
	    ]);

	    if (request()->wantsJson())
	    {
		    return response($menu, 201);
	    }

	    if ($menu->id)
	    {
		    \Cache::clear();
		    return redirect(route('admin.menus'))->with('success',
			    trans('admin/commons.messages.success.create', [ 'element' => __('admin/menus.title') ]));
	    }
	    else
	    {
		    return redirect(route('admin.menus'))->withInput()->with('error',
			    trans('admin/commons.messages.error.create', [ 'element' => __('admin/menus.title') ]));
	    }
    }


	/**
	 *
	 * @param Menu $menu
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Menu $menu)
	{
		return view('backend.menus.edit', compact('menu'));
	}


	/**
	 *
	 * @param Request $request
	 * @param Menu    $menu
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function update(Request $request, Menu $menu)
    {

	    //$this->authorize('manage', $menu);

	    $this->updateTranslations($menu, $request);

	    $request->merge([ 'modified_by' => auth()->id() ]);
	    if ($menu->update($request->except(array_merge($menu->getTranslatableAttributes(),
		    [ '_method', '_token' ]))))
		    {
			    \Cache::clear();
			    return redirect(route('admin.menus'))->with('success', trans('admin/commons.messages.success.update', ['element' => __('admin/menus.title')]));
		    }
		    else
		    {
			    return redirect(route('admin.menus'))->withInput()->with('error', trans('admin/commons.messages.error.update', ['element' => __('admin/menus.title')]));
		    }
    }


	/**
	 * @param Menu $menu
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function getModalDelete(Menu $menu)
	{
		$this->authorize('delete', $menu);

		$model         = 'menus';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.menus.delete', [ $menu ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/menus.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 *
	 * @param Menu $menu
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Menu $menu)
	{
		$this->authorize('delete', $menu);

		if ($menu->delete())
		{
			\Cache::clear();
			return redirect(route('admin.menus'))->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/menus.title') ]));
		}
		else
		{
			return redirect(route('admin.menus'))->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/menus.title') ]));
		}
	}
}
