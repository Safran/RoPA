<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;

/**
 * Class SettingController
 *
 * @package App\Http\Controllers\Backend
 */
class SettingController extends Controller
{

	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
    	$settings = Setting::whereActive(true)->orderBy('ordering')->get()->groupBy('group');

    	return view('backend.settings.index', compact('settings'));
    }


	/**
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request)
    {
	    $settings = Setting::whereActive(true)->orderBy('ordering')->get();
	    $got = $request->get('settings');
	    foreach($settings as $setting)
	    {
	    	if(array_key_exists($setting->key, $got))
		    {
			    $setting->value = $got[$setting->key];
			    $setting->save();
		    }
	    }
	    return redirect()->back()->with('ok', __('admin/settings.saved-success'));
    }
}
