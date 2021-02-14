@component('mail::message')
# Welcome to MyCommunity Please Verify Your Account

Hi {{ $payload['member']->email }}

Your new account is ready, please use the login button below to verify your email address and set your password.

@component('mail::button', ['url' => $link])
Log In
@endcomponent

Thanks,<br>
The {{ config('app.name') }} Team

##### PS -- if that link doesn't work in your browser, you can just copy and paste this link:

{{$link}}

@endcomponent
