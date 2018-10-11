<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Events;

use App\Models\Statement;
use Illuminate\Queue\SerializesModels;

class StatementCreated
{
    use SerializesModels;

	/**
	 * @var Statement
	 */
    protected $statement;


	/**
	 * StatementCreated constructor.
	 *
	 * @param Statement $statement
	 */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

	public function subject()
	{
		return $this->statement;
	}
}
