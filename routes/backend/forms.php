<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Forms
 */
Route::get('/forms', 'FormController@index')->name('forms');
Route::get('/form/create', 'FormController@create')->name('forms.create');
Route::get('/form/publish/{form}', 'FormController@publish')->name('forms.publish');
Route::get('/form/delete/{form}', 'FormController@destroy')->name('forms.delete');
Route::get('/form/{form}/confirm-delete','FormController@getModalDelete')->name('forms.confirm-delete');
Route::get('/form/edit/{form}', 'FormController@edit')->name('forms.edit');
Route::put('/form/update/{form}', 'FormController@update')->name('forms.update');

// Publish progression
Route::get('/form/publish/status/{id}', 'FormController@getPublishStatus')->name('forms.publish.status');
/**
 * Formpage
 */
Route::get('/pages/{form}/create', 'FormPageController@create')->name('pages.create');
Route::post('/pages/{form}', 'FormPageController@store')->name('pages.store');
Route::get('/pages/{form}/edit/{formPage}', 'FormPageController@edit')->name('pages.edit');
Route::put('/pages/{form}/update/{formPage}', 'FormPageController@update')->name('pages.update');

Route::patch('/pages/saveOrder', 'FormPageController@saveOrder')->name('pages.save_order');

Route::get('/pages/{form}/{formPage}/delete', 'FormPageController@destroy')->name('pages.delete');
Route::get('/pages/{form}/{formPage}/confirm-delete',
	'FormPageController@getModalDelete')->name('pages.confirm-delete');

/**
 * Formelement
 */
Route::get('/elements/{form}/data/{formPage}', 'FormElementController@data')->name('elements.data');

Route::get('/elements/{form}/create', 'FormElementController@create')->name('elements.create');
Route::patch('/elements/saveOrder', 'FormElementController@saveOrder')->name('elements.save_order');

Route::get('/elements/{form}/create/{formPage?}', 'FormElementController@create')->name('elements.create');
Route::post('/elements/{form}', 'FormElementController@store')->name('elements.store');
Route::get('/elements/{form}/edit/{formElement}', 'FormElementController@edit')->name('elements.edit');
Route::put('/elements/{form}/update/{formElement}', 'FormElementController@update')->name('elements.update');

Route::get('/elements/{form}/{formElement}/delete', 'FormElementController@destroy')->name('elements.delete');
Route::get('/elements/{form}/{formElement}/confirm-delete',
	'FormElementController@getModalDelete')->name('elements.confirm-delete');

Route::get('/elements/{form}/special/{formElement}',
	'FormElementController@getSpecialHtml')->name('elements.specialhtml');

Route::get('/elements/{formElement}/values', 'FormElementController@getPossibleValue')->name('elements.values');
