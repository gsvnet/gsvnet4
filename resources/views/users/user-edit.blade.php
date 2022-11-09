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

    {{ Form::open(array('route' => 'updateProfile')) }}

    {{ Form::text('email', Auth::user()->email) }}

    {{ Form::password('password') }}
    {{ Form::password('password_confirmation') }}


    {{ Form::submit('Verzend') }}
    {{ Form::close() }}    
    </body>
</html>
