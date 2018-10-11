<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
	protected $settings;


	public function run()
	{
		$this->settings = [
			[
				'key'         => 'home_picture_descktop',
				'label'        => json_encode([
					'fr' => 'Photo page d\'accueil ( Version bureau )',
					'en' => 'Home page picture ( Desktop )']),
				'type'       => 'FILE',
				'active'      => 1,
				'value'       => '',
			],
			[
				'key'         => 'home_picture_pad',
				'label'        => json_encode([
					'fr' => 'Photo page d\'accueil ( Version tablette )',
					'en' => 'Home page picture ( Pad )']),
				'type'       => 'FILE',
				'active'      => 1,
				'value'       => '',
			],
		];

		foreach ($this->settings as $index => $setting) {
			$result = DB::table('settings')->insert($setting);
			if (!$result) {
				$this->command->info("Error while inserting $index setting.");
				return;
			}
		}
		$this->command->info('Seeder [ Settings ] : '.count($this->settings).' settings saved.');
	}
}