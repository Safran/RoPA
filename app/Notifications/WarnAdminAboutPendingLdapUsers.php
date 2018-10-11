<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class WarnAdminAboutPendingLdapUsers extends Notification
{
    use Queueable;

    protected $pendings;


	/**
	 * WarnAdminAboutPendingLdapUsers constructor.
	 *
	 * @param Collection $pendings
	 */
    public function __construct(Collection $pendings)
    {
        $this->pendings = $pendings;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
	    return ( new MailMessage )->markdown('emails.warnadminldap', [
		    'notifiable' => $notifiable,
		    'url'        => url('/'),
		    'pendings' => $this->pendings
	    ])->subject(trans_choice('emails/warnadminldap.subject', $this->pendings->count(), [ 'fullname' => $notifiable->full_name, 'count' => $this->pendings->count() ]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
