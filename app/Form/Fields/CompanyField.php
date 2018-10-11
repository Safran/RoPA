<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */



namespace App\Form\Fields;

use App\Models\Company;

/**
 * Class CompanyField
 *
 * @package App\Form\Fields
 */
class CompanyField extends Field
{
	/**
	 *
	 * @var bool
	 */
	protected $hasHelp = false;

	/**
	 *
	 * @return mixed
	 */
	public function getDefault()
	{
		// Par défaut notre société
		//$me = auth()->user();
		//return $me->company->id;
		return null;
	}

	public function getDefaultValue()
	{
		//$me = auth()->user();
		//return $me->company->id;
		return null;
	}

	/**
	 *
	 * @param null $value
	 *
	 * @return Company|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
	 */
	public function getValue($value = null)
	{
		$value = parent::getValue($value);
		if(isset($value))
		{
			try {
				$company = Company::findOrFail((int)$value);
			}catch (\Exception $e)
			{
				$company = new Company;
			}
		} else return null;

		return $company;
	}

	/**
	 *
	 * @param null $value
	 *
	 * @return int|mixed
	 */
	public function getValueToJson($value = null)
	{
		// Supposed to get company id
		$value = parent::getValue($value);
		if(isset($value)) return (int)$value;
		return null;
	}

	public function getValueAsString($value = null)
	{
		$value = $this->getValue($value);
		if(isset($value)) return (string)$value->name;
		return '';
	}
}