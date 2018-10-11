<?php

namespace App\Events;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class StatementValidated
 *
 * @package App\Events
 */
class StatementValidated
{

	use SerializesModels;

	/**
	 *
	 * @var Statement
	 */
	protected $statement;

	/**
	 *
	 * @var User
	 */
	protected $user;


	/**
	 * StatementValidated constructor.
	 *
	 * @param Statement $statement
	 * @param User      $user
	 */
	public function __construct(Statement $statement, User $user)
	{
		$this->statement = $statement;
		$this->user      = $user;
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
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->user;
	}
}
