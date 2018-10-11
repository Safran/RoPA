<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

use App\Models\FormElement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormElementPolicy
{
    use HandlesAuthorization, AdminPolicy;



    public function __construct()
    {
        //
    }

    public function manage(User $user)
    {
		return false;
    }

    public function commenttemplate(User $user, FormElement $formElement)
    {
        return false; // Only admin
    }

	public function deletecommenttemplate(User $user, FormElement $formElement)
	{
		return false; // Only admin
	}
}
