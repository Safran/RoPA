<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Listeners;

use App\Events\StatementSupervised;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStatementSupervised implements ShouldQueue
{
	use InteractsWithQueue;


	/**
	 * NotifyStatementSupervised constructor.
	 *
	 */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  StatementSupervised  $event
     * @return void
     */
    public function handle(StatementSupervised $event)
    {
	    $me = $event->user();
	    tap($event->subject(), function($statement) use($me) {

		    User::where(function($query) use($me, $statement) {
			    $query->whereIn('role', [ 'admin', 'lawyer' ]);
			    $query->whereIn('id', [$statement->created_by, $statement->owner_id], 'or');
		    })->where('id', '<>', $me->id)->get()->each->notify(new \App\Notifications\StatementSupervised($statement));
	    });
    }
}
