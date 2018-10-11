<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;

class LoginFromSaml2
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
	 * @param  Saml2LoginEvent $event
	 *
	 * @return void
	 */
	public function handle(Saml2LoginEvent $event)
	{
		$messageId = $event->getSaml2Auth()->getLastMessageId();

		$user       = $event->getSaml2User();
		$attributes = $user->getAttributes();

		// Load
		$last_name  = $this->getClaimOrDefault($attributes, config('authcompany.claim.last_name'));
		$first_name = $this->getClaimOrDefault($attributes, config('authcompany.claim.first_name'));
		$email      = $this->getClaimOrDefault($attributes, config('authcompany.claim.email'));
		$company    = $this->getClaimOrDefault($attributes, config('authcompany.claim.company'), env('DEFAULT_COMPANY_NAME', '-'));

		if ($company)
		{
			try
			{
				$company = Company::where('name', $company)->firstOrFail();
			}
			catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e)
			{
				// New company
				$company = Company::make([ 'name' => $company ])->save();
			}
		}

		// Find user
		try
		{
			$laravelUser = User::where('username', $user->getUserId())->firstOrFail();
		}
		catch (\Exception $e)
		{
			// Get profile for auto create
			$profile = [
				'sid'            => $user->getUserId(),
				'username'       => $this->getClaimOrDefault($attributes, config('authcompany.claim.uid')),
				'email'          => $email,
				'last_name'      => $last_name,
				'first_name'     => $first_name,
				'active'         => true,
				'company_id'     => $company->id,
				'last_connexion' => Carbon::now(),
			];
		}

		$userData = [
			'id'           => $user->getUserId(),
			'attributes'   => $user->getAttributes(),
			'assertion'    => $user->getRawSamlAssertion(),
			'sessionIndex' => $user->getSessionIndex(),
			'nameId'       => $user->getNameId()
		];
		if (isset($laravelUser))
		{
			$laravelUser->last_connexion = Carbon::now();
		}
		else
		{
			// New user ?
			// Create it LDAP will update it at next synchro
			if ( ! env('SAML2_AUTOCREATE_ACCOUNT', false))
			{
				abort(403, 'Access denied');
			}
			$laravelUser = new User;
			foreach ($profile as $key => $value)
			{
				$laravelUser->{$key} = $value;
			}
			$laravelUser->password = bcrypt(str_random(60));
		}
		$laravelUser->save();

		session([ 'sessionIndex' => $userData['sessionIndex'] ]);
		session([ 'nameId' => $userData['nameId'] ]);

		\Auth::login($laravelUser);
	}


	private function getClaimOrDefault($attributes, $claimKey, $default = 'N/A')
	{
		if (array_key_exists($claimKey, $attributes))
		{
			return $attributes[$claimKey][0];
		}

		return $default;
	}
}
