@extends('layouts.app')
{!! config(['app.title'  => 'Create your new Password']) !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Reset Password
            </h2>

            {!! Form::open(['route' => 'users.auth.password.handlereset']) !!}
                {!! Form::hidden('token', $token) !!}

                {!! Form::bsEmail('email', 'E-Mail Address', old('email'), [
                    'placeholder' => 'Your E-Mail...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password', 'Password', [
                    'placeholder' => 'Your new Password...',
                    'required' => 'required'
                ]) !!}

                {!! Form::bsPassword('password_confirmation', 'Confirm Password', [
                    'placeholder' => 'Confirm your new Password...',
                    'required' => 'required'
                ]) !!}

                <div class="form-group text-xs-center">
                    {!! Form::submit('Reset Password', ['class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
