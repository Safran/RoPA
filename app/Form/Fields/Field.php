<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Form\Fields;

use App\Models\FormElement;
use Illuminate\Http\Request;

/**
 * Class Field
 *
 * @package App\Form\Fields
 */
abstract class Field
{

	/**
	 * Element associated to the field
	 *
	 * @var FormElement
	 */
	protected $element;

	/**
	 * Current request
	 *
	 * @var Request
	 */
	protected $request;


	/**
	 * Field constructor.
	 *
	 * @param FormElement $element
	 * @param Request     $request
	 */
	public function __construct(FormElement $element, Request $request)
	{
		$this->element = $element;
		$this->request = $request;
	}


	/**
	 * @var bool
	 */
	protected $hasLabel = true;

	/**
	 * @var bool
	 */
	protected $hasHelp = true;

	/**
	 * @var bool
	 */
	protected $hasPlaceholder = true;

	/**
	 * @var bool
	 */
	protected $hasSpecial = false;

	/**
	 * @var string
	 */
	protected $specialType = 'text';


	/**
	 * To parse stored value
	 *
	 * @param null $value store value
	 *
	 * @return mixed
	 */
	public function getValue($value = null)
	{
		return @unserialize($value);
	}


	/**
	 * Get the value for humans
	 *
	 * @param null $value
	 *
	 * @return string
	 */
	public function getValueAsString($value = null)
	{
		$value = $this->getValue($value);
		return (string)$value;
	}


	/**
	 * Get special inputs
	 *
	 * @return string
	 */
	public function getSpecial()
	{
		return '';
	}


	/**
	 * Get Special as object
	 *
	 * @return \stdClass
	 */
	public function getSpecialAsObject()
	{
		return new \stdClass();
	}


	/**
	 * Get Special ready to be saved
	 *
	 * @param Request $request
	 *
	 * @return null
	 */
	public function getSpecialToSave(Request $request)
	{
		return null;
	}


	/**
	 * Get validation rules
	 *
	 * @return array
	 */
	public function getRule()
	{
		return [];
	}


	/**
	 * Get the default value
	 *
	 * @return null
	 */
	public function getDefaultValue()
	{
		return null;
	}


	/**
	 *
	 * @return bool
	 */
	public function hasLabel()
	{
		return $this->hasLabel;
	}


	/**
	 * @return bool
	 */
	public function hasHelp()
	{
		return $this->hasHelp;
	}


	/**
	 * @return bool
	 */
	public function hasPlaceholder()
	{
		return $this->hasPlaceholder;
	}


	/**
	 * @return bool
	 */
	public function hasSpecial()
	{
		return $this->hasSpecial;
	}


	/**
	 * @return string
	 */
	public function specialType()
	{
		return $this->specialType;
	}


	/**
	 * @param null $value
	 *
	 * @return mixed
	 */
	public function getValueToJson($value = null)
	{
		return $this->getValue($value);
	}

	public function isExportable(): bool
	{
		return true;
	}
}