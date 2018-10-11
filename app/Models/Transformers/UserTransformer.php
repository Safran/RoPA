<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 *
 * @package App\Models\Transformers
 */
class UserTransformer extends TransformerAbstract
{

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public function transform(User $user)
	{
		return [
			'id'        => $user->id,
			'name'      => $user->full_name,
			'role'      => $user->role,
			'company'   => $user->company->name,
		];
	}
}