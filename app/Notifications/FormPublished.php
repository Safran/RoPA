<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Notifications;

use App\Models\Form;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FormPublished extends Notification
{

	use Queueable;

	protected $form;
	protected $user;


	/**
	 * FormPublished constructor.
	 *
	 * @param Form $form
	 * @param User $user
	 */
	public function __construct(Form $form, User $user)
	{
		$this->form = $form;
		$this->user = $user;
	}


	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed $notifiable
	 *
	 * @return array
	 */
	public function via($notifiable)
	{
		return [ 'database' ];
	}


	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray($notifiable)
	{

		return [
			'id'      => $this->form->id,
			'user_id' => $this->user->id,
			'title'   => $this->form->title,
		];
	}
}
