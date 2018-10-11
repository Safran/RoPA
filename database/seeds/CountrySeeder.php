<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('countries')->delete();
		$countries = json_decode(file_get_contents(database_path('factories/countries.json')), true);
		foreach ($countries as $id => $country)
		{
			DB::table('countries')->insert([
				'id'                => $id,
				'capital'           => ( ( isset($country['capital']) ) ? $country['capital'] : null ),
				'citizenship'       => ( ( isset($country['citizenship']) ) ? $country['citizenship'] : null ),
				'country_code'      => $country['country-code'],
				'currency'          => ( ( isset($country['currency']) ) ? $country['currency'] : null ),
				'currency_code'     => ( ( isset($country['currency_code']) ) ? $country['currency_code'] : null ),
				'currency_sub_unit' => ( ( isset($country['currency_sub_unit']) ) ? $country['currency_sub_unit'] : null ),
				'currency_decimals' => ( ( isset($country['currency_decimals']) ) ? $country['currency_decimals'] : null ),
				'full_name'         => ( ( isset($country['full_name']) ) ? $country['full_name'] : null ),
				'iso_3166_2'        => $country['iso_3166_2'],
				'iso_3166_3'        => $country['iso_3166_3'],
				'name'              => $country['name'],
				'region_code'       => $country['region-code'],
				'sub_region_code'   => $country['sub-region-code'],
				'eea'               => (bool) $country['eea'],
				'calling_code'      => $country['calling_code'],
				'currency_symbol'   => ( ( isset($country['currency_symbol']) ) ? $country['currency_symbol'] : null ),
				'flag'              => ( ( isset($country['flag']) ) ? $country['flag'] : null ),
			]);
		}
		$this->command->info('Seeder [ Countries ] : '.count($countries).' countries saved.');
	}
}
