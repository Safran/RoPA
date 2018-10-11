<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		factory(App\Models\Company::class, 20)->create();

		factory(App\Models\User::class, 30)->create();

		$company = \App\Models\Company::create([
			'name' => 'Company',
		]);

		collect([
			[ 'admin', 'Secret', 'Admin', 'admin@changethisemail.changethisdomain' ]
		])->each(function ($admin) use ($company) {
			[ $userName, $firstName, $lastName, $email ] = $admin;
			\App\Models\User::create([
				'username'   => $userName,
				'first_name' => $firstName,
				'last_name'  => $lastName,
				'email'      => $email,
				'password'   => bcrypt(strtolower($firstName)),
				'role'       => 'admin',
				'active'     => true,
				'company_id' => $company->id,
			]);
		});

		collect([
			[ 'juriste', 'Secret', 'Juriste', 'juriste@changethisemail.changethisdomain' ]
		])->each(function ($lawyer) use ($company) {
			[ $userName, $firstName, $lastName, $email ] = $lawyer;
			\App\Models\User::create([
				'username'   => $userName,
				'first_name' => $firstName,
				'last_name'  => $lastName,
				'email'      => $email,
				'password'   => bcrypt(strtolower($firstName)),
				'role'       => 'lawyer',
				'active'     => true,
				'company_id' => $company->id,
			]);
		});

		collect([
			[ 'salarie', 'Secret', 'Salarie', 'salarie@changethisemail.changethisdomain' ]
		])->each(function ($lawyer) use ($company) {
			[ $userName, $firstName, $lastName, $email ] = $lawyer;
			\App\Models\User::create([
				'username'   => $userName,
				'first_name' => $firstName,
				'last_name'  => $lastName,
				'email'      => $email,
				'password'   => bcrypt(strtolower($firstName)),
				'role'       => 'employee',
				'active'     => true,
				'company_id' => $company->id,
			]);
		});
	}
}
