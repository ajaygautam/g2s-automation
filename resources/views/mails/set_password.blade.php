Hi {{$user->first_name}},<br />

You can set your password here:<br />
<a href="{{env('APP_URL')}}/set_password/{{$user->set_password_hash}}">Set Password</a><br />

<br />
Thanks