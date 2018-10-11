<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LogoutEvent;

class LogoutFromSaml2
{

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
	 * @param  Saml2LogoutEvent $event
	 *
	 * @return void
	 */
	public function handle(Saml2LogoutEvent $event)
	{
		session()->forget('sessionIndex');
		session()->forget('nameId');
		\Auth::logout();
		\Session::save();
	}
}
