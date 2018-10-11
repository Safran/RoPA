<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Middleware;


use Carbon\Carbon;
use Closure;

/**
 * Class LocaleMiddleware
 *
 *
 * @package App\Http\Middleware
 */
class LocaleMiddleware
{
	public function handle($request, Closure $next)
	{
		if (session()->has('locale') &&
			in_array(session()->get('locale'), array_keys(config('locale.languages'))))
		{
			app()->setLocale(session()->get('locale'));
			setlocale(LC_TIME, config('locale.languages')[session()->get('locale')][1]);
			Carbon::setLocale(config('locale.languages')[session()->get('locale')][0]);
		}
	}
}