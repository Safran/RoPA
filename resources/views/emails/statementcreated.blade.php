@component('mail::message')
    # @lang('emails/statementcreated.subject', ['fullname' => $notifiable->full_name])


    @lang('emails/statementcreated.greetings', ['fullname' => $notifiable->full_name])

    @lang('emails/statementcreated.body', ['project' => $statement->get('name')])

    @component('mail::button', ['url' => $url])
        {{ config('app.name') }}
    @endcomponent