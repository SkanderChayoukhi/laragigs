<p>
    Hi {{ $user->name }},
</p>
<p>
    Please click the link below to verify your email address:
</p>
<p>
    <a href="{{ route('users.verify', $token) }}">{{ route('users.verify', $token) }}</a>
</p>
