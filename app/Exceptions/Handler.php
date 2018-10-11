<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];


	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 *
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);
	}


	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Exception                $exception
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
	 */
	public function render($request, Exception $exception)
	{
		/** Magic redirection to local on 404 */
		if ($exception instanceof NotFoundHttpException)
		{
			$default_locale = tryToDetermineCurrenteLocale();
			$locale         = $request->segment(1);

			if ( ! isValidLocale($locale))
			{
				$uri = $request->getUriForPath('/' . $default_locale . $request->getPathInfo());

				return redirect($uri, 301);
			}
		}

		return parent::render($request, $exception);
	}
}
