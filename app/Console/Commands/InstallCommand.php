<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Question\Question;

/**
 * Class InstallCommand
 * @package App\Console\Commands
 */
class InstallCommand extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'RoPA:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install RoPA';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info('===== RoPA Installation ======');
		if (!$this->confirm('Do you really want to install RoPA?', false))
		{
			$this->error('===== CANCELLED ======');
			return;
		}

		if ( ! file_exists('.env'))
		{
			copy('.env.example', '.env');
			$this->line('-> .env file successfully created!');
		}

		if (strlen(config('app.key')) === 0)
		{
			$this->call('key:generate');
			$this->line('-> Secret key properly generated!');
		}
		$this->line('-> Database set!');
		$this->call('cache:clear');

		$this->info('===== Installation complete =====');
	}

	public function askHiddenWithDefault($question, $fallback = true)
	{
		$question = new Question($question, 'null');
		$question->setHidden(true)->setHiddenFallback($fallback);

		return $this->output->askQuestion($question);
	}


	protected function updateEnvironmentFile($updatedValues)
	{
		$envFile = $this->laravel->environmentFilePath();
		foreach ($updatedValues as $key => $value)
		{
			file_put_contents($envFile, preg_replace("/{$key}=(.*)/", "{$key}={$value}", file_get_contents($envFile)));
		}
	}


	protected function migrateDatabaseWithFreshCredentials($credentials)
	{
		foreach ($credentials as $key => $value)
		{
			$configKey = strtolower(str_replace('DB_', '', $key));
			if ($configKey === 'password' && $value == 'null')
			{
				config([ "database.connections.mysql.{$configKey}" => '' ]);
				continue;
			}
			config([ "database.connections.mysql.{$configKey}" => $value ]);
		}
		$this->call('migrate');
	}

}
