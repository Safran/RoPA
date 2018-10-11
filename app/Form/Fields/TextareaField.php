<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

class TextareaField extends Field
{


	public function getDefaultValue()
	{
		return '';
	}

	public function getRule()
	{
		$rules = [ 'max:1000' ];

		return $rules;
	}

	public function getValue($value = null)
	{
		$value = parent::getValue($value);
		return preg_replace('/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/si', 'isset($1) ? $1 : $2', $value);
	}

}