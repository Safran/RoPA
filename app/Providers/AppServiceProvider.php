<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    Schema::defaultStringLength(191);

	    \Blade::if('admin', function () {
		    return auth()->check() && (auth()->user()->role === 'admin');
	    });

	    \Blade::if('lawyer', function () {
		    return auth()->check() && (in_array(auth()->user()->role, ['admin','lawyer']));
	    });

	    \Blade::component('components.statementbox', 'statementbox');
	    \Blade::component('components.statementtable', 'statementtable');

	    \Blade::component('components.nocontent', 'nocontent');

	    try {
	    	// Only load settings if database is correct
		    // That let us use php artisan spdp:install
		    \DB::connection()->getPdo();
		    $settings = Setting::all();
		    foreach ($settings as $key => $setting) {
			    \Config::set('settings.'.$setting->key, $setting->value);
		    }
	    } catch (\Exception $e) {
	    }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->singleton('Menu', function ($app) {
		    return new \App\Services\Menu();
	    });
	    if ($this->app->environment() !== 'production') {
		    $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
	    }
    }
}
