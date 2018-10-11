<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Events;

use App\Models\Comment;
use App\Models\Statement;
use Illuminate\Queue\SerializesModels;

class StatementCommented
{

	use SerializesModels;

	/**
	 * @var Statement
	 */
	protected $statement;

	/**
	 * @var Comment
	 */
	protected $comment;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	protected $creator;

	/**
	 * StatementCommented constructor.
	 *
	 * @param Statement $statement
	 * @param Comment $comment
	 */
	public function __construct(Statement $statement, Comment $comment)
	{
		$this->statement = $statement;
		$this->comment   = $comment;
		$this->creator   = auth()->user();
	}


	/**
	 * @return array
	 */
	public function subject()
	{
		return [ 'statement' => $this->statement, 'comment' => $this->comment, 'creator' => $this->creator ];
	}
}
