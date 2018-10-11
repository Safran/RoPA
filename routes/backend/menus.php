<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Menus
 */
Route::get('/menus', 'MenuController@index')->name('menus');
Route::get('/menus/create', 'MenuController@create')->name('menus.create');
Route::post('/menus', 'MenuController@store')->name('menus.store');
Route::get('/menus/edit/{menu}', 'MenuController@edit')->name('menus.edit');
Route::put('/menus/update/{menu}', 'MenuController@update')->name('menus.update');

Route::get('/menus/{menu}/delete', 'MenuController@destroy')->name('menus.delete');
Route::get('/menus/{menu}/confirm-delete', 'MenuController@getModalDelete')->name('menus.confirm-delete');

/**
 * Menu items
 */
Route::get('/menuitems/{menu}', 'MenuItemController@index')->name('menuitems');
Route::get('/menuitems/{menu}/create', 'MenuItemController@create')->name('menuitems.create');
Route::post('/menuitems/{menu}', 'MenuItemController@store')->name('menuitems.store');
Route::get('/menuitems/{menu}/edit/{menuItem}', 'MenuItemController@edit')->name('menuitems.edit');
Route::put('/menuitems/{menu}/update/{menuItem}', 'MenuItemController@update')->name('menuitems.update');
Route::patch('/menuitems/saveOrder', 'MenuItemController@saveOrder')->name('menuitems.save_order');

Route::get('/menuitems/{menuItem}/delete', 'MenuItemController@destroy')->name('menuitems.delete');
Route::get('/menuitems/{menuItem}/confirm-delete', 'MenuItemController@getModalDelete')->name('menuitems.confirm-delete');

