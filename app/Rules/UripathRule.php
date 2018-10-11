<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UripathRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
	    return (bool) preg_match("/^(?:[\\w#!:\\.\\?\\+=&@\$'~*,;\\/\\(\\)\\[\\]\\-]|%[0-9a-f]{2})+\$/i", $value);
	}

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.uripath');
    }
}
