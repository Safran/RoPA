<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class NotificationController
 *
 * @package App\Http\Controllers\Frontend
 */
class NotificationController extends Controller
{

	/**
	 *
	 * @param Request              $request
	 * @param DatabaseNotification $notification
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request,  DatabaseNotification $notification)
	{
		$notification->markAsRead();

		return response([], 204);
	}
}
