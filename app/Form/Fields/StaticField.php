<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Form\Fields;

use Illuminate\Http\Request;

class StaticField extends Field
{
	protected $hasLabel = false;

	protected $hasHelp = false;

	protected $hasPlaceholder = false;

	protected $hasSpecial = true;

	protected $specialType = 'editor';


	public function getSpecial()
	{
		return view('partials.form.fields.translatableinputtextarea', [
			'label'    => __('admin/forms.element.fields.static.label'),
			'name'     => 'special',
			'required' => true,
			'value'    => isset($this->element->special) ? json_decode($this->element->special, false) : '',
			'model'    => isset($this->element) ? $this->element : null,
		]);
	}

	public function getSpecialAsObject()
	{
		$value = json_decode($this->element->special, false );
		return isset($value->{locale()}) ? $value->{locale()} : '';
	}

	public function getSpecialToSave(Request $request)
	{
		return collect($request->special);
	}

	public function getDefaultValue()
	{
		return 'not-relevant';
	}

	public function isExportable(): bool
	{
		return false;
	}
}