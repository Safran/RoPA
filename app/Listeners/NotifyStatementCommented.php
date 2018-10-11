<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Listeners;

use App\Events\StatementCommented;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStatementCommented implements ShouldQueue
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
     * @param  StatementCommented  $event
     * @return void
     */
    public function handle(StatementCommented $event)
    {
	    tap($event->subject(), function($subject) {

		    User::where(function($query) use($subject) {
			    $query->whereIn('id', [$subject['statement']->supervisor_id, $subject['statement']->created_by, $subject['statement']->owner_id]);
		    })->where('id', '<>', $subject['creator']->id)->get()->each->notify(new \App\Notifications\StatementCommented($subject['statement'], $subject['comment']));
	    });
    }
}
