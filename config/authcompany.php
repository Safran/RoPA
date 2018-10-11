<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


return [
	'synchronize' => env('SAFRAN_SYNC_LDAP_USERS', false),
	'claim'       => [
		'uid'        => 'uid',
		'last_name'  => 'last_name',
		'first_name' => 'first_name',
		'email'      => 'email',
		'company'    => 'company',
	],
	'ldap'        => [
		'sid'        => 'sid',
		'first_name' => 'first_name',
		'last_name'  => 'last_name',
		'username'   => 'username',
		'email'      => 'email',
		'company'    => 'company',
	],
];