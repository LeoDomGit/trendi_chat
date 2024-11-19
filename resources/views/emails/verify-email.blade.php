@component('mail::message')

Thank you for choosing {{ config('app.name') }}.<br> 

Use the following OTP to complete your sign up process.<br>

<b>{{$otp}}</b><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
