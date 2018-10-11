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

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	public function manage(User $user)
	{
		return $user->is_admin;
	}

	public function data(User $user)
	{
		return $user->hasRole('lawyer'); // mini lawyer
	}

	public function destroy(User $me, User $user)
	{
		return $me->is_admin &&
			!(
				($user->hasMinimumRights('lawyer') && ($user->supervisedStatements->count() > 0)) ||
				($user->hasMinimumRights('employee') && ($user->statements->count() > 0)) ||
				($user->role == 'admin')
			);
	}

	public function massassign(User $me)
	{
		return $me->is_admin;
	}

	public function updateRole(User $me, User $user)
	{
		return $me->is_admin;
	}
}
