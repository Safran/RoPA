<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Requests;

use App\Form\Exceptions\FieldTypeDoesNotExists;
use App\Models\FormElement;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ElementRequest
 *
 * @package App\Http\Requests
 */
class ElementRequest extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 * @throws FieldTypeDoesNotExists
	 */
	public function rules()
	{
		$id = isset($this->formElement) ? ',' . $this->formElement->id : '';

// Sanitize
		$input = $this->all();
		$input['name'] = str_slug($input['name'], '_');
		$this->replace($input);

		try
		{
			$className = FormElement::type(isset($this->type) ? $this->type : $this->formElement->type);
			$input     = new $className(new FormElement, request());
		}
		catch (\Exception $e)
		{
			throw new FieldTypeDoesNotExists($this->type . $e->getMessage());
		}

		$result = [
			'name'    => 'required|max:255|unique_with:form_elements,page_id,id' . $id,
			'page_id' => 'required',
			'type'    => 'required_with:id',
		];
		if ($input->hasLabel())
		{
			$result = array_merge([
				'label.*' => 'required|min:3',
			], $result);
		}

		return $result;
	}
}
