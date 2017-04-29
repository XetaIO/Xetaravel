@extends('layouts.app')
{!! config(['app.name' => 'Join us !']) !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center mt-2">
                Register
            </h2>
            {!! Form::open(['route' => 'users_auth_register']) !!}
                {!! Form::bsText('username', 'Username', old('username'), [
                    'placeholder' => 'Your Username...',
                    'required' => 'required',
                    'autofocus'
                ]) !!}

                {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                    'placeholder' => 'Your E-Mail...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password', 'Password', [
                    'placeholder' => 'Your Password...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password_confirmation', 'Confirm Password', [
                    'placeholder' => 'Confirm your Password...',
                    'required' => 'required'
                ]) !!}

                {!! Recaptcha::render() !!}

                {!! Form::bsCheckbox("terms", null, false, "By clicking on \"Register\", you accept that you have read and understand the Terms.") !!}

                <div class="form-group text-xs-center">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> Register', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-link" href="{{ route('users_auth_login') }}">
                            Already an account?
                        </a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
