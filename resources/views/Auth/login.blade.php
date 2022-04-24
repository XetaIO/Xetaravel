@extends('layouts.app')
{!! config(['app.title' => 'Login into your account']) !!}

@push('meta')
    <x-meta title="Login into your account" />
@endpush

@section('content')
<div class="container mt-6 pb-4">
    <div class="row">
        @if (config('settings.user.login.enabled'))
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

                <div class="text-xs-center">
                    {!! link_to(route('auth.driver.redirect', ['driver' => 'github']), 'Login with Github <i class="fa fa-github"></i>', ['class' => 'btn btn-outline-secondary'], true, false) !!}
                </div>
            </div>
            <div class="col-md-12 text-xs-center">
                <a class="btn btn-link" href="{{ route('users.auth.password.request') }}">
                    Forgot Your Password?
                </a>
                <a class="btn btn-link" href="{{ route('users.auth.register') }}">
                    Not registered yet?
                </a>
            </div>
        @else
            <div class="col-md-4 offset-md-4">
                <h2 class="text-xs-center mt-2">
                    Whoops
                </h2>
            </div>
            <div class="col-md-8  offset-md-2 text-xs-center mt-6">
                <div role="alert" class="alert alert-danger">
                    <i aria-hidden="true" class="fa fa-exclamation fa-2x pb-1"></i><br>
                    The login system is currently disabled, please try again later.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
