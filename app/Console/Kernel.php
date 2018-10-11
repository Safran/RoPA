<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
	    Commands\InstallCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    	// Schedule backups
	    $schedule->command('backup:clean')->daily()->at('01:00');
	    $schedule->command('backup:run')->daily()->at('02:00');

	    // Schedule statement monitor
	    $schedule->command('statements:monitor')->weeklyOn(2, '11:00');

	    // LDAP synchro
	    if(config('authcompany.synchronize', false) === true)
	    {
	    	//$schedule->command('adldap:import', ['--no-interaction'])->everyFifteenMinutes();
		    $schedule->command('adldap:import', ['--no-interaction'])->daily()->at('02:00');
	    }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
