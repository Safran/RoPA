<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentTemplatePolicy
{
    use HandlesAuthorization, AdminPolicy;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


	/**
	 * @param User $user
	 *
	 * @return bool
	 */
    public function data(User $user)
    {
    	return $user->hasRole('lawyer');
    }


	/**
	 * @param User $user
	 *
	 * @return bool
	 */
    public function delete(User $user)
    {
    	return false; // Only admin
    }
}
