@extends('layouts.app')
{!! config(['app.title' => 'Reset your password']) !!}

@push('meta')
    <x-meta title="Reset your password" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<div class="container mt-6 pb-4">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-xs-center font-xeta mt-2">
                Reset Password
            </h2>

            {!! Form::open(['route' => 'users.auth.password.email']) !!}
                {!! Form::bsEmail('email', 'E-Mail Address', old('email'), [
                    'placeholder' => 'Your E-Mail...',
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

                <div class="form-group text-xs-center">
                    {!! Form::button('<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Password Reset Link', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
