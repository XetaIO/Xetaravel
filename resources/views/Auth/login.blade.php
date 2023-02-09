@extends('layouts.app')
{!! config(['app.title' => 'Login into your account']) !!}

@push('meta')
    <x-meta title="Login into your account" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
                @if (config('settings.user.login.enabled'))
                    <div>
                        <h1 class="text-3xl font-xetaravel text-center mb-2">
                            Login
                        </h1>

                        <x-form.form method="post" action="{{ route('users.auth.login') }}">
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

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary gap-2">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                    Login
                                </button>
                            </div>
                        </x-form.form>

                        <div class="text-center mb-3">
                            <a class="btn gap-2" href="{{ route('auth.driver.redirect', ['driver' => 'github']) }}">
                                Login with Github <i class="fa-brands fa-github"></i>
                            </a>
                        </div>
                    </div>

                    <div class="text-center">
                        <a class="link link-hover link-primary mr-2" href="{{ route('users.auth.password.request') }}">
                            Forgot Your Password?
                        </a>
                        <a class="link link-hover link-primary" href="{{ route('users.auth.register') }}">
                            Not registered yet?
                        </a>
                    </div>
                @else
                    <div>
                        <h1 class="text-3xl font-xetaravel text-center mb-4">
                            Whoops
                        </h1>
                        <x-alert type="error" class="max-w-lg mb-4">
                            The login system is currently disabled, please try again later.
                        </x-alert>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
