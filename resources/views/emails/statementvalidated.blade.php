@component('mail::message')
# @lang('emails/statementvalidated.subject', ['fullname' => $notifiable->full_name])


@lang('emails/statementvalidated.greetings', ['fullname' => $notifiable->full_name])

@lang('emails/statementvalidated.body', ['project' => $statement->get('name')])

@component('mail::button', ['url' => $url])
    {{ config('app.name') }}
@endcomponent

@lang('emails/statementvalidated.thanks'),

{{ config('app.name') }}
@endcomponent