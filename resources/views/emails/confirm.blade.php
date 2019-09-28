@component('mail::message')
# Introduction
Hello {{ $user->name }}

You changed your email, so we need you to confirm your new address. Please use the button below:

@component('mail::button', ['url' =>route('verify', $user->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


