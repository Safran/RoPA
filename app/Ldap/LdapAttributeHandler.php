<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Ldap;

use Adldap\Models\User as LdapUser;
use App\Models\Company;
use App\Models\User as EloquentUser;

class LdapAttributeHandler
{

	protected function getValue($key, LdapUser $ldapUser)
	{
		$key = config('authcompany.ldap.' . $key, null);
		if ( ! $key)
		{
			return null;
		}

		return $ldapUser->getFirstAttribute($key);
	}


	public function handle(LdapUser $ldapUser, EloquentUser $eloquentUser)
	{
		$eloquentUser->sid        = $this->getValue('sid', $ldapUser);
		$eloquentUser->first_name = $this->getValue('first_name', $ldapUser);
		$eloquentUser->last_name  = $this->getValue('last_name', $ldapUser);
		$eloquentUser->username   = strtolower($this->getValue('username', $ldapUser));
		$eloquentUser->email      = $this->getValue('email', $ldapUser);
		$company                  = $this->getValue('company', $ldapUser);

		if (empty($company))
		{
			$company = env('DEFAULT_COMPANY_NAME', '-');
		}

		try
		{
			$company = Company::where('name', $company)->firstOrFail();
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e)
		{
			// New company
			$company = Company::make([ 'name' => $company ])->save();
		}
		$eloquentUser->company_id = $company->id;
		$eloquentUser->type       = 'ldap';
	}
}