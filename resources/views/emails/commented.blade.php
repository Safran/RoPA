@component('mail::message')
    #@lang('emails/commented.subject', ['fullname' => $notifiable->full_name])

    @lang('emails/commented.greetings', ['fullname' => $notifiable->full_name])

    @lang('emails/commented.body', [
    'author' => $comment->author->full_name,
    'subject' => $comment->answer->element->label,
    'declaration' => $statement->get('name')
    ])

    @lang('emails/commented.thanks'),
    {{ config('app.name') }}
@endcomponent