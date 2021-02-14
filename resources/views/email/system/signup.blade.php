@component('mail::message')
@if ($payload['payment_type'] == 'cc')
# A New MyCommunity Signup
@else
# A New MyCommunity Signup -- This customer needs their ACH payment set up. Please contact within 2 business days.
@endif


Hi SHYFTY Folks

We have a new signup:

+ Name: {{ $payload['member']['name'] }}
+ Email: {{ $payload['member']['email'] }}

### Plan: {{$payload['plan']}}

### Address
{{$payload['name']}}
{{$payload['line1']}} {{$payload['unit_number']}}
{{$payload['line2']}}
{{$payload['line3']}}
{{$payload['city']}}, {{$payload['state']}} {{$payload['postal_code']}}

@endcomponent
