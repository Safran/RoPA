<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Events;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class StatementSupervised
{
	use SerializesModels;

	/**
	 * @var Statement
	 */
	protected $statement;

	/**
	 * @var User
	 */
	protected $user;


	/**
	 * StatementSupervised constructor.
	 *
	 * @param Statement $statement
	 * @param User $user
	 */
	public function __construct(Statement $statement, User $user)
	{
		$this->statement = $statement;
		$this->user = $user;
	}


	/**
	 *
	 * @return Statement
	 */
	public function subject()
	{
		return $this->statement;
	}


	/**
	 * @return User
	 */
	public function user()
	{
		return $this->user;
	}
}