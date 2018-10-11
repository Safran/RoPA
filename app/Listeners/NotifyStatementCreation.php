<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Listeners;

use App\Events\StatementCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStatementCreation implements ShouldQueue
{

	use InteractsWithQueue;


	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}


	/**
	 * Handle the event.
	 *
	 * @param  StatementCreated $event
	 *
	 * @return void
	 */
	public function handle(StatementCreated $event)
	{
		tap($event->subject(), function ($statement) {
			if ($statement->supervisor_id)
			{
				$statement->supervisor->notify(new \App\Notifications\StatementCreated($statement));
			}
			else
			{
				User::whereIn('role',
					[ 'admin' ])->get()->each->notify(new \App\Notifications\StatementCreated($statement));
			}
		});

	}
}
