<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use App\Services\Locale\CurrentLocale;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;

class LocaleServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$locale = tryToDetermineCurrenteLocale();
		$this->app->setLocale($locale);
		setlocale(LC_TIME, $locale, $locale.'_'.Str::Upper($locale), $locale.'_'.Str::Upper($locale).'.utf8');
		Carbon::setUtf8(true);
		Carbon::setLocale($locale);
		CarbonInterval::setLocale($locale);
	}
}