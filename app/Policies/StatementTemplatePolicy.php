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

class StatementTemplatePolicy
{

	use HandlesAuthorization, AdminPolicy;

	public function store(User $user)
	{
		return in_array($user->role, [ 'admin' ]);
	}


	public function delete()
	{
		return false;
	}
}