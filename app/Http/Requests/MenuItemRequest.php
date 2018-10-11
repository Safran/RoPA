<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Requests;

use App\Rules\UripathRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class MenuItemRequest
 *
 * @package App\Http\Requests
 */
class MenuItemRequest extends FormRequest
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
	 */
	public function rules()
	{
		$id = isset($this->menuItem) ? ',' . $this->menuItem->id : '';

		return [
			'title.*'  => 'bail|required|max:255',
			'path'   => ['required', new UripathRule, 'max:255|unique:menu_items,path'.$id],
			'role'   =>  ['nullable', Rule::in(['employee', 'lawyer', 'admin'])],
		];
	}
}
