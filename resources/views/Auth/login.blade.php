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
                @if (settings('app_login_enabled'))
                    <div>
                        <h1 class="text-3xl font-xetaravel text-center mb-2">
                            Login
                        </h1>

                        <x-form method="post" action="{{ route('users.auth.login') }}">
                            <x-input class="input-primary" label="Email" placeholder="Your E-Mail..." icon="fas-at" required autofocus inline />
                            <x-password class="input-primary" label="Password" placeholder="Your Password..." required inline />

                            <fieldset class="fieldset p-4 bg-base-100 border border-base-300 rounded-box w-64">
                                <legend class="fieldset-legend">Login options</legend>
                                <label class="fieldset-label">
                                    <input name="remember" type="checkbox" checked="checked" class="checkbox" />
                                    Remember me
                                </label>
                            </fieldset>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary gap-2">
                                    <x-icon name="fas-right-to-bracket" class="h-4 w-4 inline"></x-icon>
                                    Login
                                </button>
                            </div>
                        </x-form>

                        <div class="text-center mb-3">
                            <a class="btn gap-2" href="{{ route('auth.driver.redirect', ['driver' => 'github']) }}">
                                Login with Github <x-icon name="fab-github" class="h-4 w-4 inline"></x-icon>
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
                        <div role="alert" class="alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>The login system is currently disabled, please try again later..</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
