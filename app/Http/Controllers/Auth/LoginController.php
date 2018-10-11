<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
	use AuthenticatesUsers;


	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}


	/**
	 * Username identification instead of default email one
	 *
	 * @return string
	 */
	public function username()
	{
		return 'username';
	}


	/**
	 * Redirect to home
	 *
	 * @return string
	 */
	public function redirectTo()
	{
		return locale() . '/';
	}

	/**
	 *
	 * @param Request $request
	 * @param User    $user
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	protected function authenticated(Request $request, User $user)
	{
		// Saving last connexion
		$user->last_connexion = Carbon::now();
		$user->save();

		if ($request->wantsJson())
		{
			return response()->json([ 'redirect' => $this->redirectTo ], 200);
		}

		return redirect()->intended($this->redirectPath());
	}


	/**
	 *
	 * @param Request $request
	 */
	public function logout(Request $request)
	{
		$sessionIndex = session()->get('sessionIndex', null);
		$nameId       = session()->get('nameId');
		$returnTo     = config('saml2_settings.logoutRoute');
		session()->forget('sessionIndex');
		session()->forget('nameId');
		if ( ! isset($sessionIndex))
		{
			$this->guard()->logout();
			$request->session()->invalidate();

			return redirect(route('login'));
		}
		else
		{
			$request->session()->invalidate();


			\Saml2::logout($returnTo, $nameId, $sessionIndex);
		}
	}
}
