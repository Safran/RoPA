<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Transformers\CompanyTransformer;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Class CompanyController
 *
 * @package App\Http\Controllers\Frontend
 */
class CompanyController extends Controller
{

	/**
	 * @return \Spatie\Fractal\Fractal
	 */
	public function data()
	{
		$companies = Company::all();
		return fractal($companies, new CompanyTransformer, new ArraySerializer);
	}
}
