<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Providers;

use App\Events\StatementCommented;
use App\Events\StatementCreated;
use App\Events\StatementSupervised;
use App\Events\StatementUpdated;
use App\Events\StatementValidated;
use App\Listeners\ImportingFormAdLdap;
use App\Listeners\LoginFromSaml2;
use App\Listeners\LogoutFromSaml2;
use App\Listeners\NotifyStatementCommented;
use App\Listeners\NotifyStatementCreation;
use App\Listeners\NotifyStatementModification;
use App\Listeners\NotifyStatementSupervised;
use App\Listeners\NotifyStatementValidated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        StatementCreated::class => [
            NotifyStatementCreation::class,
        ],
        StatementUpdated::class => [
	        NotifyStatementModification::class,
        ],
        StatementSupervised::class => [
	        NotifyStatementSupervised::class,
        ],
        StatementCommented::class => [
	        NotifyStatementCommented::class,
        ],
        StatementValidated::class => [
	        NotifyStatementValidated::class,
        ],
	    \Aacotroneo\Saml2\Events\Saml2LoginEvent::class => [
	        LoginFromSaml2::class
	    ],
        \Aacotroneo\Saml2\Events\Saml2LogoutEvent::class => [
	        LogoutFromSaml2::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
