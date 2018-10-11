<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

use Illuminate\Http\Request;

class RadiogroupField extends Field
{

	/**
	 * @var bool
	 */
	protected $hasHelp = true;

	protected $hasSpecial = true;// @deprecated

	protected $specialType = 'choices'; // @deprecated


	public function getSpecial()
	{
		$choices = json_decode($this->element->special, false);
		$default = null;
		if ($choices)
		{
			foreach ($choices as $choice)
			{
				if ($choice->default)
				{
					$default = $choice->value;
				}
			}
		}
		else
		{
			$choises = [];
		}

		return view('partials.form.fields.choices', compact('choices', 'default'));
	}


	public function getSpecialAsObject()
	{
		$decoded = json_decode($this->element->special, false);
		$choices = [];
		foreach ($decoded as $dec)
		{
			$choice          = new \stdClass;
			$choice->label   = $dec->label->{locale()};
			$choice->default = $dec->default;
			$choice->value   = $dec->value;
			$choices[]       = $choice;
		}

		return collect($choices);
	}


	public function getDefaultValue()
	{
		if($this->element->special)
		{
			$decoded = json_decode($this->element->special, false);
			$choices = [];
			$first = array_first($decoded, function ($choice, $key) {
				return $choice->default;
			});
			if($first)
			{
				return $first->value;
			}
		}
		return parent::getDefaultValue();
	}

	public function getSpecialToSave(Request $request)
	{
		$default = $request->get('special_default');

		return collect($request->get('special'))->filter(function (&$item, $key) {

			return is_int($key);
		})->map(function ($item) use ($default) {
			if ($item['value'] !== $default)
			{
				$item['default'] = false;
			}
			else
			{
				$item['default'] = true;
			}
			$item['value'] = (int) $item['value'];

			return (object) $item;
		});
	}


	public function getValue($value = null)
	{
		$result = $this->getDefaultValue();
		if($value === null) return $result;
		$value = parent::getValue($value);
		if($this->element->special)
		{
			$decoded = json_decode($this->element->special, false);
			if(is_object($decoded))
			{
				$decoded = collect($decoded)->toArray();
			}

			$search = array_first($decoded, function ($choice, $key) use($value) {

				return $choice->value === $value;
			});
			if($search === null)
			{
				return $result;
			}
			return $search;
		}
		return $result;
	}

	public function getValueAsString($value = null):string
	{
		$value = $this->getValue($value);
		if($value === null || ! is_object($value)) return '';

		return (string)$value->label->{locale()};
	}

	public function getValueToJson($value = null)
	{
		return parent::getValue($value);
	}
}