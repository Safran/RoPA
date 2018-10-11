<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Transformers\CountryTransformer;

/**
 * Class CountryController
 *
 * @package App\Http\Controllers\Frontend
 */
class CountryController extends Controller
{

	/**
	 *
	 * @return \Spatie\Fractal\Fractal
	 */
	public function data()
	{
		$eea           = request()->get('eea', false);
		$except_france = request()->get('except_france', false);
		$countries     = Country::when(collect([ true, 1, "1", "true" ])->containsStrict($eea), function ($query) {
			return $query->whereEea(true);
		})->when(collect([ true, 1, "1", "true" ])->containsStrict($except_france), function ($query) {
			return $query->where('name', '<>', 'France');
		})->orderBy('name')->get();
		$france        = Country::where('name', 'France')->first()->id;

		return fractal($countries, new CountryTransformer)->addMeta([ 'France' => $france ]);
	}
}
