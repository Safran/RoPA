<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Country;
use League\Fractal\TransformerAbstract;

/**
 * Class CountryTransformer
 *
 * @package App\Models\Transformers
 */
class CountryTransformer extends TransformerAbstract
{

	/**
	 * @param Country $country
	 *
	 * @return array
	 */
	public function transform(Country $country)
	{
		return [
			'id'    => $country->id,
			'name'  => $country->name,
			'flag'  => $country->flag,
		];
	}
}