@component('mail::message')
# @choice('emails/warnadminldap.subject', $pendings->count(), ['fullname' => $notifiable->full_name, 'count' => $pendings->count()])


@lang('emails/warnadminldap.greetings', ['fullname' => $notifiable->full_name])


@lang('emails/warnadminldap.body')

@component('mail::panel')


@foreach($pendings as $user)
    {{ $user->id }} - {{ $user->full_name }} - {{ $user->email }} - @choice('emails/warnadminldap.statements', $user->statements->count(), ['count' => $user->statements->count()])
@endforeach
@endcomponent

@component('mail::button', ['url' => $url])
    {{ config('app.name') }}
@endcomponent

@lang('emails/warnadminldap.thanks'),

{{ config('app.name') }}
@endcomponent