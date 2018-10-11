<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Company;
use League\Fractal\TransformerAbstract;

/**
 * Class CompanyTransformer
 *
 * @package App\Models\Transformers
 */
class CompanyTransformer extends TransformerAbstract
{

	/**
	 * @param Company $company
	 *
	 * @return array
	 */
	public function transform(Company $company)
	{
		return [
			'id'   => $company->id,
			'name' => $company->name,
			'logo' => $company->logo,
		];
	}

}