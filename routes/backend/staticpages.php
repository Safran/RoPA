<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Statics Pages
 */
Route::get('/staticpages', 'StaticpageController@index')->name('staticpages');
Route::get('/staticpages/create', 'StaticpageController@create')->name('staticpages.create');
Route::post('/staticpages', 'StaticpageController@store')->name('staticpages.store');
Route::get('/staticpages/edit/{staticpage}', 'StaticpageController@edit')->name('staticpages.edit');
Route::put('/staticpages/update/{staticpage}', 'StaticpageController@update')->name('staticpages.update');

Route::get('/staticpages/{staticpage}/delete', 'StaticpageController@destroy')->name('staticpages.delete');
Route::get('/staticpages/{staticpage}/confirm-delete', 'StaticpageController@getModalDelete')->name('staticpages.confirm-delete');
