<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class StatementPolicy
 *
 * @package App\Policies
 */
class StatementPolicy
{
	use HandlesAuthorization, AdminPolicy;

	/**
	 * Create a new policy instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function manage(User $user)
	{
		return in_array($user->role, [ 'admin', 'lawyer' ]);
	}


	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function changeCreator(User $user)
	{
		return in_array($user->role, [ 'admin']);
	}

	/**
	 *
	 * @param User      $user
	 * @param Statement $statement
	 *
	 * @return bool
	 */
	public function edit(User $user, Statement $statement)
	{
		return in_array($user->role, [
				'admin',
				'lawyer'
			]) || ( $user->id == $statement->owner->id ) || ( $user->id == $statement->author->id );
	}


	/**
	 *
	 * @param User      $user
	 * @param Statement $statement
	 *
	 * @return bool
	 */
	public function validate(User $user, Statement $statement)
	{
		return $statement->owner_id === $user->id;
	}

	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function filterbycompany(User $user)
	{
		return in_array($user->role, [
			'admin',
			'lawyer'
		]);
	}

	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function filterbystatements(User $user)
	{
		return in_array($user->role, [
			'admin',
			'lawyer'
		]);
	}

	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function filterbystatus(User $user)
	{
		return in_array($user->role, [
			'admin',
			'lawyer'
		]);
	}


	/**
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function duplicate(User $user)
	{
		return in_array($user->role, [ 'admin', 'lawyer' ]);
	}

}
