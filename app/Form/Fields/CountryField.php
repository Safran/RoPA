<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class CountryField
 *
 * @package App\Form\Fields
 */
class CountryField extends Field
{

	/**
	 * @var bool
	 */
	protected $hasHelp = false;

	/**
	 * @var bool
	 */
	protected $hasSpecial = true;// @deprecated

	/**
	 * @var string
	 */
	protected $specialType = 'settings'; // @deprecated


	/**
	 * @param null $value
	 *
	 * @return Country|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
	 */
	public function getValue($value = null)
	{
		$settings = json_decode($this->element->special, false);
		try
		{
			if(isset($settings->multiple) && $settings->multiple)
			{
				if(is_int(parent::getValue($value)))
				{
					$country = [Country::findOrFail((int) parent::getValue($value))];
				} else {
					$country = Country::findOrFail(collect(parent::getValue($value))->pluck('id'));
				}
			} else {
				$country = Country::findOrFail((int) parent::getValue($value));

			}
		}
		catch (\Exception $e)
		{
			$country = new Country;
		}

		return $country;
	}


	/**
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
	 */
	public function getSpecial()
	{
		$settings = json_decode($this->element->special, false);

		return view('partials.form.fields.countryspecial', compact('settings'));
	}


	/**
	 *
	 * @param null $value
	 *
	 * @return mixed
	 */
	public function getValueToJson($value = null)
	{
		// Supposed to get country id
		return parent::getValue($value);
	}


	public function getSpecialAsObject()
	{
		return json_decode($this->element->special, false);
	}


	/**
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Support\Collection|null
	 */
	public function getSpecialToSave(Request $request)
	{
		$settings = collect([
			'only_eea'      => $request->get('only_eea', false),
			'multiple'      => $request->get('multiple', false),
		]);

		return $settings;
	}


	/**
	 *
	 * @return int|mixed|null
	 */
	public function getDefaultValue()
	{
		return Country::where('name', 'France')->first()->id;
	}

	public function getValueAsString($value = null)
	{
		$value = $this->getValue($value);
		if(is_a($value, Collection::class))
		{
			return $value->pluck('name')->implode(", ");

		} elseif(is_array($value))
		{
			return collect($value)->pluck('name')->implode(", ");

		} else {
			return (string)$value->name;
		}
	}
}