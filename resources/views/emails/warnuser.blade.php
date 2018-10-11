
@component('mail::message')
@foreach(locales() as $locale)
# @choice('emails/warnuser.subject', $statements->count(),['fullname' => $notifiable->full_name], $locale)

@lang('emails/warnuser.greetings', ['fullname' => $notifiable->full_name], $locale)

@lang('emails/warnuser.body', [
'statements' => $statements->count()
], $locale)

@component('mail::button', ['url' => $url])
    @lang('emails/warnuser.button-title', [], $locale)
@endcomponent

@component('mail::panel')
@lang('emails/warnuser.statements', [], $locale)

@foreach($statements as $statement)
    {{ $statement->id }} - {!!  $statement->get('name') !!} - {!!  $statement->get('company')->name !!}

@endforeach
@endcomponent

@lang('emails/warnuser.thanks', [], $locale),


@lang('emails/warnuser.signature', [], $locale)

-----------------
@endforeach
@endcomponent
