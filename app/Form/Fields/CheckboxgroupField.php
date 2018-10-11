<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Form\Fields;

use Illuminate\Http\Request;

/**
 * Class CheckboxgroupField
 *
 * @package App\Form\Fields
 */
class CheckboxgroupField extends Field
{

	/**
	 * @var bool
	 */
	protected $hasHelp = true;

	/**
	 *
	 * @var bool
	 */
	protected $hasSpecial = true;

	/**
	 *
	 * @var string
	 */
	protected $specialType = 'choices';


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
	 */
	public function getSpecial()
	{
		$choices    = json_decode($this->element->special, false);
		$hasDefault = false;
		$default    = false;

		return view('partials.form.fields.choices', compact('choices', 'default', 'hasDefault'));
	}


	/**
	 *
	 * @return \Illuminate\Support\Collection|\stdClass
	 */
	public function getSpecialAsObject()
	{
		$decoded = json_decode($this->element->special, false);
		$choices = [];
		foreach ($decoded as $dec)
		{
			$choice        = new \stdClass;
			$choice->label = $dec->label->{locale()};
			$choice->value = $dec->value;
			$choices[]     = $choice;
		}

		return collect($choices);
	}


	/**
	 *
	 * @return array|null
	 */
	public function getDefaultValue()
	{
		return [];
	}


	/**
	 *
	 * @param Request $request
	 *
	 * @return null|static
	 */
	public function getSpecialToSave(Request $request)
	{
		return collect($request->get('special'))
			->filter(function (&$item, $key) {
				return is_int($key);
			})->map(function ($item){
				$item['value'] = (int) $item['value'];

				return (object) $item;
			});
	}


	/**
	 * @param null $value
	 *
	 * @return array|false|int|mixed|null|string
	 */
	public function getValue($value = null)
	{
		$value = parent::getValue($value);
		if ($this->element->special && isset($value) && is_array($value))
		{
			$decoded = json_decode($this->element->special, false);
			if(is_object($decoded))
			{
				$decoded = collect($decoded)->toArray();
			}

			return array_filter($decoded, function ($choice) use ($value) {
				return in_array($choice->value, $value);
			});
		}

		return null;
	}


	public function getValueAsString($value = null)
	{
		return collect($this->getValue($value))->pluck('label')->implode(", ");
	}

	public function getValueToJson($value = null)
	{
		return parent::getValue($value);
	}
}