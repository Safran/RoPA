<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
	$companies = \App\Models\Company::all('id')->pluck('id');

	if($companies->isEmpty())
	{
		$companies = factory(App\Models\Company::class, 20)->create()->pluck('id');
	}

	return [
		'username'       => $faker->unique()->userName,
		'first_name'     => $faker->firstName,
		'last_name'      => $faker->lastName,
		'email'          => $faker->unique()->safeEmail,
		'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
		'active'         => true,
		'company_id'     => $faker->randomElement($companies->toArray()),
		'remember_token' => str_random(10),
	];
});
