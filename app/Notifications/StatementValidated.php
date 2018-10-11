<?php

namespace App\Notifications;

use App\Models\Statement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatementValidated extends Notification
{
    use Queueable;

	/**
	 *
	 * @var Statement
	 */
	protected $statement;


	/**
	 *
	 * StatementValidated constructor.
	 *
	 * @param Statement $statement
	 */
	public function __construct(Statement $statement)
	{
		$this->statement = $statement;
	}


	/**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

	public function toMail($notifiable)
	{
		return ( new MailMessage )->markdown('emails.statementvalidated', [
			'notifiable' => $notifiable,
			'url'        => url('/'),
			'statement' => $this->statement
		])->subject(__('emails/statementvalidated.subject', [ 'fullname' => $notifiable->full_name ]));
	}
}
