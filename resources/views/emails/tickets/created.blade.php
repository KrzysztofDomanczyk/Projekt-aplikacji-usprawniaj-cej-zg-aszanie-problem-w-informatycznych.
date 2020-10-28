@component('mail::message')
[IT#{{$ticket->id}}]

Hello, your request has been accepted. 
If you reply for this email, your message will be send directly to person, who takes care of your ticket.

Youre ticket has <strong>"To do"</strong> status. 
Please be patient. 
Thanks,<br>
{{ config('app.name') }}
@endcomponent
