<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






// Home page
Route::get('/', 'HomeController@show')->name('home');

// Make notification read
Route::put('/notifications/{notification}', 'NotificationController@update')->name('notifications.update');

// Create a declaration
Route::get('/statements/create/{page?}', 'StatementController@create')->name('statements.create');
Route::post('/statements', 'StatementController@store')->name('statements.store');

// Get disclaimer
Route::get('/statements/disclaimer', 'StatementController@disclaimer')->name('statements.disclaimer');

// Make disclaimer read
Route::post('/statements/disclaimer', 'StatementController@seen')->name('statements.seen');

// Get declarations lists by status
Route::get('/statements/in-progress', 'StatementController@inprogress')->name('statements.inprogress');
Route::get('/statements/finished', 'StatementController@finished')->name('statements.finished');
Route::get('/statements/pendings', 'StatementController@pendings')->name('statements.pendings');

// Show a finished declaration
Route::get('/statements/{statement}/show', 'StatementController@show')->name('statements.show');

// Edit a declaration
Route::get('/statements/{statement}/edit', 'StatementController@edit')->name('statements.edit');
Route::put('/statements/{statement}/update', 'StatementController@update')->name('statements.update');

// Upgrade declaration to last published form
Route::get('/statements/{statement}/upgrade', 'StatementController@upgrade')->name('statements.upgrade');

// Validate a declaration
Route::put('/statements/{statement}/validate', 'StatementController@validateIt')->name('statements.validate');

// Validate a declaration
Route::put('/statements/{statement}/archivate', 'StatementController@archivate')->name('statements.archivate');

// File field
Route::get('/private/{statement}/{uuid}', 'StatementController@showFile')->name('private.show');

// Set supervisor on declaration
Route::put('/statements/{statement}/supervise', 'StatementController@supervise')->name('statements.supervise');

// Set creator on declaration
Route::put('/statements/{statement}/creator', 'StatementController@creator')->name('statements.creator');


Route::get('/statements/form', 'StatementController@form')->name('statements.form');

// Get data of a declaration as JSON
Route::get('/statements/{statement}/data', 'StatementController@data')->name('statements.data');

// Get data of a delcaration as CSV
Route::get('/statements/{statement}/csv', 'StatementController@exportAnswers')->name('statements.answerscsv');

// Get data of a delcaration as CSV
Route::get('/statements/csv/{type?}', 'StatementController@exportCSV')->name('statements.csv');

// Duplicate and redirect to the duplicated statement
Route::get('/statements/{statement}/duplicate', 'StatementController@duplicate')->name('statements.duplicate');

// Get companies as JSON
Route::get('/companies/data', 'CompanyController@data')->name('companies.data');

// Get countries AS JSON
Route::get('/countries/data', 'CountryController@data')->name('countries.data');

// Get users as JSON
Route::get('/users/data', 'UserController@data')->name('users.data');
Route::get('/users/search', 'UserController@Search')->name('users.search');




Route::get('/statementtemplates/data', 'StatementTemplateController@data')->name('statementtemplates.data');
Route::get('/statementtemplates/{statementTemplate}/answers', 'StatementTemplateController@answers')->name('statementtemplates.answers');
Route::post('/statementtemplates', 'StatementTemplateController@store')->name('statementtemplates.store');
Route::delete('/statementtemplates/{statementTemplate}/delete', 'StatementTemplateController@destroy')->name('statementtemplates.destroy');


Route::get('/commenttemplates/data', 'CommentTemplateController@data')->name('commenttemplates.data');
Route::get('/commenttemplates/{formElement}/templates', 'CommentTemplateController@templates')->name('commenttemplates.templates');
Route::get('/commenttemplates/{commentTemplate}/body', 'CommentTemplateController@body')->name('commenttemplates.body');
Route::post('/commenttemplates/{formElement}', 'CommentTemplateController@store')->name('commenttemplates.store');
Route::delete('/commenttemplates/{commentTemplate}/delete', 'CommentTemplateController@destroy')->name('commenttemplates.destroy');

Route::post('/comments/{answer}', 'CommentController@store')->name('comments.store');

Route::get('/attachments/{attachment}', 'AttachmentController@show')->name('attachments.show');


Route::put('/answers/{answer}', 'AnswerController@tagHasValidate')->name('answer.validate');

Route::get('{slug}', 'StaticpageController@show')->name('staticpages.show');
