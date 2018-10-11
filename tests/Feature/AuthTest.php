<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	public function testAuthRedirectLoginOnHome()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(302, $response->status());
	}

	public function testAdminHasAccessToDashboard()
	{
		$this->withExceptionHandling()
			->signInAdmin()
			->get(route('admin.dashboard'))
			->assertStatus(Response::HTTP_OK);
	}

	public function testLawyerHasNotAccessToDashboard()
	{
		$this->withExceptionHandling()
			->signInLawyer()
			->get(route('admin.dashboard'))
			->assertStatus(Response::HTTP_FORBIDDEN);
	}

	public function testEmployeeHasNotAccessToDashboard()
	{
		$this->withExceptionHandling()
			->signIn()
			->get(route('admin.dashboard'))
			->assertStatus(Response::HTTP_FORBIDDEN);
	}
}
