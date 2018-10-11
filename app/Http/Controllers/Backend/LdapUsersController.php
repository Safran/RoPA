<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Backend;

use Adldap\AdldapInterface;

class LdapUsersController extends Controller
{
	/**
	 * @var Adldap
	 */
	protected $ldap;

	/**
	 * Constructor.
	 *
	 * @param AdldapInterface $adldap
	 */
	public function __construct(AdldapInterface $ldap)
	{
		parent::__construct();
		$this->ldap = $ldap;
	}

	/**
	 * Displays the all LDAP users.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$users = $this->ldap->search()->users()->get();

		dd($users);
		//return view('users.index', compact('users'));
	}

	/**
	 * Displays the specified LDAP user.
	 *
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		$user = $this->ldap->search()->findByGuid($id);

		dd($user);
	}
}