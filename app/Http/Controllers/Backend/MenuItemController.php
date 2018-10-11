<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */



namespace App\Http\Controllers\Backend;

use App\Http\Requests\MenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

/**
 * Class MenuItemController
 * @package App\Http\Controllers\Backend
 */
class MenuItemController extends Controller
{

	/**
	 *
	 * @param Menu    $menu
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Menu $menu, Request $request)
	{
		$menuitems = MenuItem::when($request->get('active') && !empty($request->has('active')), function ($query) use ($request) {
			$query->where('active', (bool) $request->get('active'));
		})->where('menu_id', $menu->id)->orderBy('ordering')->get();

		if($request->get('active') && !empty($request->has('active')))
		{
			$active = (bool) $request->get('active');
		} else {
			$active = null;
		}
		return view('backend.menuitems.index', compact('menuitems', 'menu', 'active'));
	}


	/**
	 *
	 * @param Menu $menu
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(Menu $menu)
	{
		return view('backend.menuitems.create', compact('menu'));
	}


	/**
	 * @param MenuItemRequest $request
	 * @param Menu            $menu
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function store(MenuItemRequest $request, Menu $menu)
	{

		//$this->authorize('manage', $form);

		$menuitem = MenuItem::create([
			'created_by' => auth()->id(),
			'path'       => $request->get('path'),
			'role'       => $request->get('role'),
			'title'      => $request->get('title'),
			'active'     => $request->get('active'),
			'menu_id'    => $menu->id,
		]);

		if (request()->wantsJson())
		{
			return response($menuitem, 201);
		}

		if ($menuitem->id)
		{
			\Cache::clear();
			return redirect(route('admin.menuitems', [$menu]))->with('success',
				trans('admin/commons.messages.success.create', [ 'element' => __('admin/menuitems.title') ]));
		}
		else
		{
			return redirect(route('admin.menuitems', [$menu]))->withInput()->with('error',
				trans('admin/commons.messages.error.create', [ 'element' => __('admin/menuitems.title') ]));
		}
	}


	/**
	 *
	 * @param Menu     $menu
	 * @param MenuItem $menuItem
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Menu $menu, MenuItem $menuItem)
	{
		return view('backend.menuitems.edit', compact('menu', 'menuItem'));
	}


	/**
	 * Saving order
	 */
	public function saveOrder()
	{
		MenuItem::setNewOrder(request('ids'));
	}


	/**
	 *
	 * @param MenuItemRequest $request
	 * @param Menu            $menu
	 * @param MenuItem        $menuItem
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(MenuitemRequest $request, Menu $menu, MenuItem $menuItem)
	{
		//$this->authorize('manage', $menu);

		$this->updateTranslations($menuItem, $request);

		$request->merge([ 'modified_by' => auth()->id() ]);
		if ($menuItem->update($request->except(array_merge($menuItem->getTranslatableAttributes(), [ '_method', '_token' ]))))
		{
			\Cache::clear();
			return redirect(route('admin.menuitems', [$menu]))->with('success', trans('admin/commons.messages.success.update', ['element' => __('admin/menuitems.title')]));
		}
		else
		{
			return redirect(route('admin.menuitems', [$menu]))->withInput()->with('error', trans('admin/commons.messages.error.update', ['element' => __('admin/menuitems.title')]));
		}
	}

	/**
	 *
	 * @param MenuItem $menuItem
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getModalDelete(MenuItem $menuItem)
	{
		$model         = 'menuitems';
		$confirm_route = $error = null;
		try
		{
			$confirm_route = route('admin.menuitems.delete', [ $menuItem ]);

			return view('layouts.common._modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
		catch (\Exception $e)
		{

			$error = trans('admin/menuitems.error.destroy', compact('id'));

			return view('backend.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
		}
	}


	/**
	 *
	 * @param MenuItem $menuItem
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(MenuItem $menuItem)
	{
		$menu = $menuItem->menu;
		if ($menuItem->delete())
		{
			\Cache::clear();
			return redirect(route('admin.menuitems', [$menu]))->with('success',
				trans('admin/commons.messages.success.delete', [ 'element' => __('admin/menuitems.title') ]));
		}
		else
		{
			return redirect(route('admin.menuitems', [$menu]))->with('success',
				trans('admin/commons.messages.error.delete', [ 'element' => __('admin/menuitems.title') ]));
		}
	}
}
