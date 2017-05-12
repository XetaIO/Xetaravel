@extends('layouts.app')
{!! config(['app.title' => 'Login into your account']) !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Login
            </h2>
            {!! Form::open(['route' => 'users.auth.login']) !!}
                {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                    'placeholder' => 'Your E-Mail...',
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsPassword('password', 'Password', [
                    'placeholder' => 'Your Password...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsCheckbox("remember", null, old('remember'), "Remember Me") !!}

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-sign-in" aria-hidden="true"></i> Login', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-12 text-xs-center">
            <a class="btn btn-link" href="{{ route('users.auth.password.request') }}">
                Forgot Your Password?
            </a>
            <a class="btn btn-link" href="{{ route('users.auth.register') }}">
                Not registered yet?
            </a>
        </div>
    </div>
</div>
@endsection
