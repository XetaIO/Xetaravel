@extends('layouts.app')
{!! config(['app.title' => 'Login into your account']) !!}

@push('meta')
    <x-meta title="Login into your account" />
@endpush

@section('content')
<section class="mx-auto">
    <div class="flex flex-col items-center">
        @if (!settings('app_login_enabled'))
            <div class="sm:h-[70px] h-[90px] md:h-[120px]"></div>
            <x-alert type="error" class="max-w-md mb-4">
                The login system is currently disabled. If you are not authorized to log in, please try again later.
            </x-alert>
        @else
            <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
        @endif

        <div class="p-8 shadow-lg rounded-lg bg-base-100 dark:bg-base-300">
            <h1 class="text-3xl text-center mb-2">
                Login
            </h1>

            <x-form method="post" action="{{ route('auth.login') }}">
                <x-input name="email" label="Email" placeholder="Your E-Mail..." icon="fas-at" required autofocus inline />
                <x-password name="password" label="Password" placeholder="Your Password..." required inline />
                <x-checkbox text="Remember me" name="remember" />

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
    </div>
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
</section>
@endsection
