<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

namespace App\ViewComposers;

use App\Notifications\FormPublished;
use App\Notifications\StatementCommented;
use App\Notifications\StatementCreated;
use App\Notifications\StatementSupervised;
use App\Notifications\StatementUpdated;
use App\Notifications\UserConnected;
use Illuminate\View\View;

class HeaderComposer
{

	public function compose(View $view)
	{
		$notifs = auth()->user()->unreadNotifications;

		$notifications = collect();
		$users         = collect();

		foreach ($notifs as $notif)
		{
			$notification        = new \stdClass;
			$notification->date  = $notif->created_at->formatLocalized('%x');
			$notification->link  = '';
			$notification->title = '';
			$notification->id    = $notif->id;
			$user                = null;

			if (array_key_exists('user_id', $notif->data))
			{
				$user_id = $notif->data['user_id'];
				if ( ! $users->has($user_id))
				{
					$users[$user_id] = \App\Models\User::find($user_id);
				}
				$user = $users->has($user_id) ? $users[$user_id] : null;
			}

			switch ($notif->type)
			{
				case StatementCommented::class:

					$notification->title = __('notifications.commented', [
						'user'    => $user ? $user->full_name : '',
						'project' => $notif->data['title'],
					]);
					$notification->link  = route('frontend.statements.edit', [ $notif->data['id'] ]);

					break;
				case FormPublished::class:
					$notification->title = __('notifications.form-published');
					break;
				case StatementCreated::class:
					$notification->title = __('notifications.statement-created', [
						'user'    => $user ? $user->full_name : '',
						'project' => $notif->data['title'],
					]);
					$notification->link  = route('frontend.statements.edit', [ $notif->data['id'] ]);

					break;
				case StatementSupervised::class:
					$notification->title = __('notifications.statement-supervised', [
						'user'    => $user ? $user->full_name : '',
						'project' => $notif->data['title'],
					]);
					$notification->link  = route('frontend.statements.edit', [ $notif->data['id'] ]);

					break;
				case StatementUpdated::class:
					$notification->title = __('notifications.statement-updated', [
						'user'    => $user ? $user->full_name : '',
						'project' => $notif->data['title'],
					]);
					$notification->link  = route('frontend.statements.edit', [ $notif->data['id'] ]);

					break;
				case UserConnected::class:
					$notification->title = __('notifications.user-connected', [
						'user' => $user ? $user->full_name : ''
					]);
					break;
				default:
					$notification->title = 'Unknown [' . $notif->type . ']';
			}
			$notifications[] = $notification;
		}
		$messages = json_decode(@file_get_contents(public_path('js/messages.json')));

		$view->with(compact('notifications', 'messages'));
	}
}