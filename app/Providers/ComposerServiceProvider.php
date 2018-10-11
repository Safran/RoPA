<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use App\ViewComposers\HeaderComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		View::composer(
			['frontend/*'],
			HeaderComposer::class
		);
	}

	public function register()
	{
	}
}