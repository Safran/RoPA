<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Form\Fields;

class FileField extends Field
{

	protected $hasHelp = false;

	protected $hasPlaceholder = false;


	public function getDefaultValue()
	{
		return '';
	}

	public function getRule()
	{
		$max_size = (int)ini_get('upload_max_filesize') * 1000;

		return ['nullable','file','mimes:jpg,bmp,png,doc,docx,odt,csv,xls,xlsx,ods,pdf', 'max:'.$max_size];
	}


    public function getValueAsString($value = null)
	{
		$file = $this->getValue($value);
		return $file ? (string)$file->name : '';
	}

}