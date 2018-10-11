<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Middleware;

use Closure;

class DebugBarMiddleware
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//if ( ! \Auth::check() || ! in_array(\Auth::user()->id, [ 31, 64 ]) ||
		//	( app()->environment() === 'production' ))
		//{
			\Debugbar::disable();
		//}

		return $next($request);
	}
}
