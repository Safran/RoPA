<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	public $baseUrl = 'http://localhost';

	protected function setUp()
	{
		parent::setUp();
		Schema::enableForeignKeyConstraints();
		$this->disableExceptionHandling();
	}

	protected function signIn($user = null)
	{
		$user = $user ?: create(\App\Models\User::class);
		$user->role = 'employee';
		$this->actingAs($user);
		return $this;
	}

	protected function signInLawyer($lawyer = null)
	{
		$lawyer = $lawyer ?: create(\App\Models\User::class);
		$lawyer->role = 'lawyer';
		$this->actingAs($lawyer);
		return $this;
	}

	protected function signInAdmin($admin = null)
	{
		$admin = $admin ?: create(\App\Models\User::class);
		$admin->role = 'admin';
		$this->actingAs($admin);
		return $this;
	}

	protected function disableExceptionHandling()
	{
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
		$this->app->instance(ExceptionHandler::class, new class extends Handler {
			public function __construct()
			{
			}
			public function report(\Exception $e)
			{
			}
			public function render($request, \Exception $e)
			{
				throw $e;
			}
		});
	}
	protected function withExceptionHandling()
	{
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
		return $this;
	}
}
