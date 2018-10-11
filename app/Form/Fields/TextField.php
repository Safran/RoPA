<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

/**
 * Class TextField
 *
 * @package App\Form\Fields
 */
class TextField extends Field
{

	/**
	 *
	 * @return null|string
	 */
	public function getDefaultValue()
	{
		return '';
	}


	/**
	 *
	 * @return array
	 */
	public function getRule()
	{
		$rules = [ 'max:255' ];

		return $rules;
	}


	/**
	 *
	 * @param null $value
	 *
	 * @return mixed|null|string|string[]
	 */
	public function getValue($value = null)
	{
		$value = parent::getValue($value);
		return preg_replace('/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/si', 'isset($1) ? $1 : $2', $value);
	}
}