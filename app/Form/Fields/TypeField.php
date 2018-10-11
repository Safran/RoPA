<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

class TypeField extends Field
{

	public function getDefaultValue()
	{
		return 'company';
	}
}