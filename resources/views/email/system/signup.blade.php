@component('mail::message')
# A New MyCommunity Signup

Hi SHYFTY Folks

We have a new signup:

+ Name: {{ $payload['member']['name'] }}
+ Email: {{ $payload['member']['email'] }}

@endcomponent
