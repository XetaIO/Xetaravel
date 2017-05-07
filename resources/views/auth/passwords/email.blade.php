@extends('layouts.app')
{!! config(['app.title' => 'Reset your password']) !!}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Reset Password
            </h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {!! Form::open(['route' => 'users.auth.email']) !!}
                {!! Form::bsEmail('email', 'E-Mail Address', old('email'), [
                    'placeholder' => 'Your E-Mail...',
                    'required' => 'required'
                ]) !!}

                <div class="form-group text-xs-center">
                    {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
