<?php

namespace App\Listeners;

use App\Events\StatementValidated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStatementValidated implements ShouldQueue
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
     * @param  StatementValidated  $event
     * @return void
     */
    public function handle(StatementValidated $event)
    {
	    $me = $event->user();
	    tap($event->subject(), function($statement) use($me) {
	    	$supervisor = User::where(function($query) use($me, $statement) {
			    $query->whereIn('role', [ 'admin', 'lawyer' ]);
			    $query->where('id', $statement->supervisor_id);
		    })->where('id', '<>', $me->id)->first();
	    	if($supervisor)
		    {
			    $supervisor->notify(new \App\Notifications\StatementValidated($statement));
		    }
	    });
    }
}
