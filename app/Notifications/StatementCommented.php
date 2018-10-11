<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Notifications;

use App\Models\Comment;
use App\Models\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatementCommented extends Notification implements ShouldQueue
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */

	protected $statement;

	protected $comment;


	/**
	 * StatementCommented constructor.
	 *
	 * @param Statement $statement
	 * @param Comment $comment
	 */
	public function __construct(Statement $statement, Comment $comment)
	{
		$this->statement = $statement;
		$this->comment   = $comment;
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
			'id'      => $this->statement->id,
			'title'   => $this->statement->get('name'),
			'user_id' => $this->statement->supervisor_id,
		];
	}


	/**
	 * Get the mail representation of the notification.
	 *
	 * @param $notifiable
	 *
	 * @return MailMessage
	 */
	public function toMail($notifiable)
	{
		return ( new MailMessage )->markdown('emails.commented',
			[ 'statement' => $this->statement, 'comment' => $this->comment, 'notifiable' => $notifiable ])
			->subject(__('emails/commented.subject', ['fullname' => $notifiable->full_name]));
	}
}
