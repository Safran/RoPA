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
Route::get('/companies', 'CompanyController@index')->name('companies');
Route::get('/companies/data', 'CompanyController@data')->name('companies.data');

Route::post('/companies/{company}/lawyer', 'CompanyController@assignLawyer')->name('companies.assignlawyer');
