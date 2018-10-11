<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Translations
 */
Route::get('/translations', 'TranslationController@index')->name('translations');
Route::post('/translations', 'TranslationController@store')->name('translations.store');
Route::put('/translations/{languageLine}', 'TranslationController@update')->name('translations.update');

Route::get('/translations/refresh', 'TranslationController@refresh')->name('translations.refresh');
