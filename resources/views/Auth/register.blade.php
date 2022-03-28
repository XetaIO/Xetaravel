@extends('layouts.app')
{!! config(['app.title' => 'Join us !']) !!}

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<div class="container mt-6">
    <div class="row">
        @if (config('settings.user.register.enabled'))
            <div class="col-md-4 offset-md-4">
                <h2 class="text-xs-center font-xeta mt-2">
                    Register
                </h2>
                {!! Form::open(['route' => 'users.auth.register']) !!}
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

                    <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-danger' : '' }}">
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('g-recaptcha-response') }}
                                </div>
                            @endif
                        </div>

                    {!! Form::bsCheckbox("terms", null, false, "By clicking on \"Register\", you accept that you have read and understand the Terms.") !!}

                    <div class="form-group text-xs-center">
                        <div class="col-md-12 mb-1">
                            {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i> Register', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! link_to(
                                route('auth.driver.redirect', ['driver' => 'github']),
                                'Register with Github <i class="fa fa-github"></i>',
                                ['class' => 'btn btn-outline-secondary'],
                                true,
                                false
                            )!!}
                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-link" href="{{ route('users.auth.login') }}">
                                Already an account?
                            </a>
                        </div>
                    </div>
                {!! Form::close() !!}
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
                    The registration system is currently disabled, please try again later.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
