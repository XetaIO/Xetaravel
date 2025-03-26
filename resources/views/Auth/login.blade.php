@extends('layouts.app')
{!! config(['app.title' => 'Login into your account']) !!}

@push('meta')
    <x-meta title="Login into your account" />
@endpush

@section('content')
<section class="mx-auto">
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
    <div class="flex flex-col items-center">
        @if (settings('app_login_enabled'))
            <div class="p-8 shadow-lg rounded-lg dark:bg-base-300">
                <h1 class="text-3xl font-xetaravel text-center mb-2">
                    Login
                </h1>

                <x-form method="post" action="{{ route('auth.login') }}">
                    <x-input class="input-primary" name="email" label="Email" placeholder="Your E-Mail..." icon="fas-at" required autofocus inline />
                    <x-password class="input-primary" name="password" label="Password" placeholder="Your Password..." required inline />
                    <x-checkbox label="Remember me" name="remember" />

                    <div class="text-center mb-3">
                        <x-button icon="fas-right-to-bracket" type="submit" label="Login" class="btn-primary gap-2" />
                    </div>
                </x-form>

                <div class="text-center mb-3">
                    <x-button link="{{ route('auth.driver.redirect', ['driver' => 'github']) }}" icon-right="fab-github" label="Login with Github" class="gap-2" />
                </div>

                <div class="text-center">
                    <a class="link link-hover link-primary mr-2" href="{{ route('auth.password.request') }}">
                        Forgot Your Password?
                    </a>
                    <a class="link link-hover link-primary" href="{{ route('auth.register') }}">
                        Not registered yet?
                    </a>
                </div>
            </div>
        @else
            <div>
                <h1 class="text-3xl font-xetaravel text-center mb-4">
                    Whoops
                </h1>
                <x-alert type="error" class="max-w-lg mb-4">
                    The login system is currently disabled, please try again later...
                </x-alert>
            </div>
        @endif
    </div>
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
</section>
@endsection
