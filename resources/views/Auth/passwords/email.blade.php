@extends('layouts.app')
{!! config(['app.title' => 'Reset your password']) !!}

@push('meta')
    <x-meta title="Reset your password" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="mx-auto">
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
    <div class="flex flex-col items-center">
        <div class="p-8 shadow-lg rounded-lg bg-base-100 dark:bg-base-300">
            <h1 class="text-3xl text-center mb-2">
                Reset Password
            </h1>

            <x-form method="post" action="{{ route('auth.password.email') }}">
                <x-input class="input-primary" name="email" label="Email" placeholder="Your E-Mail..." icon="fas-at" required autofocus inline />

                <div class="form-control my-2">
                    {!! NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                        </label>
                    @endif
                </div>

                <div class="text-center mb-3">
                    <x-button icon="far-paper-plane" type="submit" label="Send Password Reset Link" class="btn-primary gap-2" />
                </div>
                <div class="text-center">
                    <a class="link link-hover link-primary" href="{{ route('auth.login') }}">
                        Already an account?
                    </a>
                    <a class="link link-hover link-primary" href="{{ route('auth.register') }}">
                        Not registered yet?
                    </a>
                </div>
            </x-form>
        </div>
    </div>
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
</section>
@endsection
