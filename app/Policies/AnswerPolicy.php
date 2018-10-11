<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
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
	 *
	 * @param User   $user
	 * @param Answer $answer
	 *
	 * @return bool
	 */
	public function manage(User $user, Answer $answer)
	{
		return $user->hasRole('lawyer') && $user->id == $answer->supervisor_id;
	}


	/**
	 *
	 * @param User   $user
	 * @param Answer $answer
	 *
	 * @return bool
	 */
	public function canValidate(User $user, Answer $answer)
	{
		return $user->hasRole('lawyer') && $user->id == $answer->statement->supervisor_id;
	}


	/**
	 *
	 * @param User   $user
	 * @param Answer $answer
	 *
	 * @return bool
	 */
	public function comment(User $user, Answer $answer)
	{
		return ($user->hasRole('lawyer') && ($user->id == $answer->statement->supervisor_id)) ||
			   collect([$answer->statement->owner_id, $answer->statement->created_by])->unique()->contains($user->id);
	}
}
