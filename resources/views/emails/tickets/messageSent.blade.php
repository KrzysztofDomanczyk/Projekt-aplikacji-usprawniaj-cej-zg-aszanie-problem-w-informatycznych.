@component('mail::message')
[IT#{{$ticket->id}}]

<p>{{$content}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
