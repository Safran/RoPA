<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */







/**
 * Auth routes / Basic authentifications
 */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


/**
 * Backends routes
 */
Route::group(['namespace' => 'Backend',
              'prefix' => 'admin',
              'as' => 'admin.',
              'middleware' => [  'web', 'auth', 'admin' ]
], function () {

	include_route_files(__DIR__.'/backend/');
});

/**
 * Frontends routes
 */
Route::group(['namespace' => 'Frontend',
              'as' => 'frontend.',
              'middleware' => [ 'web', 'auth.saml2'  ]
				], function () {
	include_route_files(__DIR__.'/frontend/');
});
