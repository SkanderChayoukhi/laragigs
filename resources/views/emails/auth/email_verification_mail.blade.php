<x-mail::message>

Hello {{$user->name}},

<x-mail::button :url="route('verify_email',$user->verification_token)">
Click Here to verify your email address !
</x-mail::button>
<p>Or copy paste the following link on your web browser to verify your email address</p>
<p><a href="{{route('verify_email',$user->verification_token)}}">
{{route('verify_email',$user->verification_token)}}</a></p>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
