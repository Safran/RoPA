<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MenuRequest
 *
 * @package App\Http\Requests
 */
class MenuRequest extends FormRequest
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
	    $id = isset($this->menu) ? ','.$this->menu->id : '';
	    return [
		    'title.*' => 'bail|required|max:255',
		    'slug' => 'required|alpha_dash|max:255|unique:menus,slug'.$id
	    ];
    }
}
