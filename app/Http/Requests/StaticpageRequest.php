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
 * Class StaticpageRequest
 *
 * @package App\Http\Requests
 */
class StaticpageRequest extends FormRequest
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
    	$id = isset($this->staticpage) ? ','.$this->staticpage->id : '';
        return [
	        'title.*' => 'bail|required|max:255',
	        'body.*' => 'bail|required|max:65000',
            'slug' => 'required|alpha_dash|max:255|unique:staticpages,slug'.$id
        ];
    }
}
