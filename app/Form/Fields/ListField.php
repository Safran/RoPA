<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

/**
 * Class ListField
 * @package App\Form\Fields
 */
class ListField extends Field
{

	/**
	 * @return null
	 */
	public function getDefault()
	{
		return [];
	}

	public function getValue($value = null)
	{
		$value = parent::getValue($value);
		if($value === null || ! is_array($value))
		{
			return [];
		}
		return $value;
	}

	public function getValueAsString($value = null)
	{
		return implode(", ", $this->getValue($value));
	}

}