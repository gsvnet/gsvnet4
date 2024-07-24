<html>
<body>
@if ($errors->any())
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

{{ html()->modelForm($user, 'PUT')->route('updateProfile')->open() }}

{{ html()->text('email', Auth::user()->email) }}

{{ html()->password('password') }}
{{ html()->password('password_confirmation') }}


{{ html()->submit('Verzend') }}
{{ html()->closeModelForm() }}
</body>
</html>
