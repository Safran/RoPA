<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use Barryvdh\Elfinder\ElfinderServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

/**
 * Class ElfinderServiceProvider
 *
 * Special override
 *
 * @package App\Providers
 */
class ElfinderServiceProvider extends ServiceProvider
{
	public function boot(Router $router)
	{
		$viewPath = __DIR__.'/../resources/views';
		$this->loadViewsFrom($viewPath, 'elfinder');
		$this->publishes([
			$viewPath => base_path('resources/views/vendor/elfinder'),
		], 'views');

		if (!defined('ELFINDER_IMG_PARENT_URL')) {
			define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/studio-42/elfinder'));
		}

		$config = $this->app['config']->get('elfinder.route', []);
		$config['namespace'] = 'Barryvdh\Elfinder';

		$router->group($config, function($router)
		{
			$router->get('/',  ['as' => 'elfinder.index', 'uses' =>'ElfinderController@showIndex']);
			$router->get('popup/{input_id}', ['as' => 'elfinder.popup', 'uses' => 'ElfinderController@showPopup']);
			$router->get('filepicker/{input_id}', ['as' => 'elfinder.filepicker', 'uses' => 'ElfinderController@showFilePicker']);
			$router->get('tinymce', ['as' => 'elfinder.tinymce', 'uses' => 'ElfinderController@showTinyMCE']);
			$router->get('tinymce4', ['as' => 'elfinder.tinymce4', 'uses' => 'ElfinderController@showTinyMCE4']);
			$router->get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
		});


		/**
		 * Special override on elfinder route to remove admin middleware
		 * and allow every auth users to access images via connector
		 */
		$config = $this->app['config']->get('elfinder.connector_route', []);
		$config['namespace'] = 'Barryvdh\Elfinder';
		$router->group($config, function($router) {
			$router->any('connector', [ 'as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector' ]);
		});
	}
}