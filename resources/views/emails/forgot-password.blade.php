@component('mail::message')

Dear {{$name}},

You password has been reset.<br>
Your new password is: {{$password}} 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
