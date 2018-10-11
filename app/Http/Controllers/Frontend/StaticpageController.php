<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Staticpage;
use Illuminate\Http\Request;

/**
 * Class StaticpageController
 * @package App\Http\Controllers\Frontend
 */
class StaticpageController extends Controller
{

	/**
	 *
	 * @param Request $request
	 * @param         $slug
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request, $slug)
	{
		$staticpage = Staticpage::whereSlug($slug)->firstOrFail();

		return view('frontend.staticpages.show', compact('staticpage'));
	}
}
