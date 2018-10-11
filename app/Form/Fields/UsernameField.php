<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

use App\Models\User;

/**
 * Class UsernameField
 *
 * @package App\Form\Fields
 */
class UsernameField extends Field
{

	/**
	 * @var bool
	 */
	protected $hasHelp = false;
	/**
	 *
	 * @return mixed
	 */
	public function getDefault()
	{
		return auth()->user()->id;
	}

	public function getDefaultValue()
	{
		return auth()->user()->id;
	}

	/**
	 * @param null $value
	 *
	 * @return User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
	 */
	public function getValue($value = null)
	{
		try {
			$user = User::findOrFail((int)parent::getValue($value));
		}catch (\Exception $e)
		{
			$user = new User(['active' => false]);
		}

		return $user;
	}


	/**
	 * @param null $value
	 *
	 *
	 * @return int|mixed
	 */
	public function getValueToJson($value = null)
	{
		// Supposed to get username id
		return (int)parent::getValue($value);
	}

	public function getValueAsString($value = null)
	{
		return (string)$this->getValue($value)->full_name;
	}
}