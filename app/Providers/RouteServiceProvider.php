<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';


	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
		Route::pattern('_locale', locales()->implode('|'));

		Route::matched(function (RouteMatched $event) {

			$locale = $event->route->parameter('_locale');

			if (isValidLocale($locale))
			{
				\URL::defaults([ '_locale' => $locale ]);
				\App::setLocale($locale);
				setlocale(LC_TIME, $locale);
				Carbon::setLocale($locale);
				CarbonInterval::setLocale($locale);
			}
		});
		parent::boot();
	}


	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();

		$this->mapWebRoutes();
	}


	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::middleware('web')
			->namespace($this->namespace)->get('/', function () {
				return redirect(tryToDetermineCurrenteLocale());
			});
		Route::middleware('web')
			->prefix(locale())
			->namespace($this->namespace)
			->group(base_path('routes/web.php'));
	}


	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		Route::prefix('api')
			->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
	}
}
