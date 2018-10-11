<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Listeners;

use App\Events\StatementUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStatementModification implements ShouldQueue
{

	use InteractsWithQueue;


	/**
	 * NotifyStatementModification constructor.
	 *
	 */
	public function __construct()
	{
	}


	/**
	 * Handle the event.
	 *
	 * @param  StatementUpdated $event
	 *
	 * @return void
	 */
	public function handle(StatementUpdated $event)
	{
		$me = $event->user();
		tap($event->subject(), function ($statement) use ($me) {
			if ($statement->supervisor_id)
			{
				$statement->supervisor->notify(new \App\Notifications\StatementUpdated($statement));
			}
			else
			{
				User::whereIn('role', [ 'admin' ])->where('id', '<>',
						$me->id)->get()->each->notify(new \App\Notifications\StatementUpdated($statement));
			}
		});
	}
}
