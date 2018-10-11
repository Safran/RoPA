<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Users
 */
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/{user}/confirm-updaterole/{role}', 'UserController@getModalUpdateRole')->name('users.confirm-updaterole');
Route::put('/users/{user}/role', 'UserController@updateRole')->name('users.updaterole');
Route::get('/users/{user}/delete', 'UserController@destroy')->name('users.delete');
Route::get('/users/{user}/confirm-delete', 'UserController@getModalDelete')->name('users.confirm-delete');

Route::get('/users/csv', 'UserController@csv')->name('users.csv');


Route::get('/users/datas', 'UserController@datas')->name('users.datas');

/**
 * Ldapusers For testing TODO: remove on production
 */
Route::get('/ldapusers', 'LdapUsersController@index')->name('ldapusers');
Route::get('/ldapusers/{user}/show', 'LdapUsersController@show')->name('ldapusers.show');


Route::get('/users/{user}/confirm-mass-assign', 'UserController@getModalMassAssign')->name('users.confirm-mass-assign');
Route::put('/users/{user}/mass-assign', 'UserController@MassAssign')->name('users.mass-assign');
