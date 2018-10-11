<?php

namespace App\Notifications;

use App\Models\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class WarnUserAboutInprogressStatements extends Notification
{

	use Queueable;

	protected $statements;


	/**
	 * WarnUserAboutInprogressStatements constructor.
	 *
	 * @param Collection $statements
	 */
	public function __construct(Collection $statements)
	{
		$this->statements = Statement::findMany($statements);
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
		return [ 'mail' ];
	}


	public function toMail($notifiable)
	{
		return ( new MailMessage )->markdown('emails.warnuser', [
				'notifiable' => $notifiable,
				'url'        => url('/statements/in-progress'),
				'statements' => $this->statements
			])->subject(trans_choice('emails/warnuser.subject', $this->statements->count(),[ 'fullname' => $notifiable->full_name ]));

	}
}
