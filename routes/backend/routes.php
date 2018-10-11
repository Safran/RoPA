<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






/**
 * Dashboard
 */
Route::get('/', 'Controller@dashboard')->name('dashboard');

/**
 * Statements from dashboard
 */
Route::get('/statements', 'Controller@statements')->name('statements.data');

Route::get('/statements/{statement}/delete', 'Controller@StatementDestroy')->name('statements.delete');
Route::get('/statements/{statement}/confirm-delete','Controller@getStatementModalDelete')->name('statements.confirm-delete');


