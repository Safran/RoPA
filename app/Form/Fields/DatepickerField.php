<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Form\Fields;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class DatepickerField
 *
 * @package App\Form\Fields
 */
class DatepickerField extends Field
{

	/**
	 *
	 * @var bool
	 */
	protected $hasHelp = false;

	/**
	 *
	 * @var bool
	 */
	protected $hasSpecial = true;// @deprecated

	/**
	 *
	 * @var string
	 */
	protected $specialType = 'settings'; // @deprecated


	/**
	 *
	 * @return array
	 */
	public function getRule()
	{
		$rules = [];
		if ($this->element && ($this->element->field_required !== true))
		{
			$rules[] = 'nullable';
		}
		$rules[] = 'date_format:Y-m-d';

		return $rules;
	}


	public function getValue($value = null)
	{
		$result = $this->getDefaultValue();
		if ($value === null)
		{
			return $result;
		}
		$value = parent::getValue($value);

		if ($value)
		{// example 2018-03-29T20:13:22+02:00
			try
			{
				$date = Carbon::createFromFormat(Carbon::W3C, $value);
			}
			catch (\Exception $e)
			{
				try
				{
					$date = Carbon::createFromFormat('Y-m-d', $value)->setTime(0, 0, 0);
				}
				catch (\Exception $e)
				{
					$date = Carbon::now()->setTime(0, 0, 0);
				}
			}

			return $date;
		}
		else
		{
			return $result;
		}
	}


	public function getValueToJson($value = null)
	{
		$result = $this->getDefaultValue();
		if ($result !== null)
		{
			$result = $result->format("Y-m-d");
		}
		if ($value === null)
		{
			return $result;
		}
		$value = parent::getValue($value);
		if ($value)
		{
			try
			{
				$date = Carbon::createFromFormat("Y-m-d", $value)->setTime(0, 0, 0);

				return $date->format("Y-m-d");
			}
			catch (\Exception $e)
			{
				return $result;
			}
		}

		return $result;
	}


	public function getDefaultValue()
	{
		$settings = $this->getSpecialAsObject();

		if (isset($settings->default_to_now) && $settings->default_to_now)
		{
			return today();
		}

		return parent::getDefaultValue();
	}


	public function getSpecial()
	{
		$settings = json_decode($this->element->special, false);

		return view('partials.form.fields.datepickerspecial', compact('settings'));
	}

	public function getSpecialAsObject()
	{
		$special                 = json_decode($this->element->special, false);
		$special->default_to_now = (bool) $special->default_to_now;

		return $special;
	}

	public function getSpecialToSave(Request $request)
	{
		$settings = collect([
			'default_to_now' => $request->get('default_to_now', false),
		]);

		return $settings;
	}


	public function getValueAsString($value = null)
	{
		$value = $this->getValue($value);
		if ($value)
		{
			return (string) $value->toDateString();
		}

		return '';
	}

}