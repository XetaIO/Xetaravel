@extends('layouts.app')
{!! config(['app.title' => 'Join us !']) !!}

@push('meta')
    <x-meta title="Join us !" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="mx-auto">
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
    <div class="flex flex-col items-center">
        @if (settings('app_register_enabled'))
            <div class="p-8 shadow-lg rounded-lg dark:bg-base-300">
                <h1 class="text-3xl text-center mb-2">
                    Register
                </h1>

                <x-form method="post" action="{{ route('auth.register') }}">
                    <x-input class="input-primary" name="username" label="Username" value="{{ old('username') }}" placeholder="Your Username..." icon="fas-user" required autofocus inline />
                    <x-input class="input-primary" name="email" label="Email" value="{{ old('email') }}" placeholder="Your E-Mail..." icon="fas-at" required inline />
                    <x-password class="input-primary" name="password" label="Password" placeholder="Your Password..." required inline />
                    <x-password class="input-primary" name="password_confirmation" label="Confirm Password" placeholder="Confirm your Password..." required inline />

                    <div class="form-control mx-auto">
                        {!! NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                            </label>
                        @endif
                    </div>

                    <x-checkbox label="By clicking on 'Register', you accept that you have read and understand the <a class='link link-primary' href='{{ route('page.terms') }}'>Terms</a>." name="terms" />

                    <div class="text-center">
                        <div class="mb-2">
                            <x-button icon="fas-user-plus" type="submit" label="Register" class="btn-primary gap-2" />
                        </div>
                        <div class="mb-2">
                            <x-button link="{{ route('auth.driver.redirect', ['driver' => 'github']) }}" icon-right="fab-github" label="Register with Github" class="gap-2" />
                        </div>
                        <div >
                            <a class="link link-hover link-primary" href="{{ route('auth.login') }}">
                                Already an account?
                            </a>
                        </div>
                    </div>
                </x-form>
            </div>
        @else
            <div>
                <h1 class="text-3xl text-center mb-4">
                    Whoops
                </h1>
                <x-alert type="error" class="max-w-lg mb-4">
                    The registration system is currently disabled, please try again later.
                </x-alert>
            </div>
        @endif
    </div>
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
</section>
@endsection
