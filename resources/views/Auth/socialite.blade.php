@extends('layouts.app')
{!! config(['app.title' => 'Join us !']) !!}

@push('meta')
    <x-meta title="Join us !" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="mx-3">
        <div class="flex flex-col items-center">
            <x-alert type="error" class="max-w-lg mb-4">
                There are some errors while registering your account. Please fix these errors before to continue.
            </x-alert>
            <h1 class="text-3xl text-center mb-2">
                Register with {{ Str::title(session('socialite.driver')) }}
            </h1>

            <x-form method="post" action="{{ route('auth.driver.register.validate', ['driver' => session('socialite.driver')]) }}">
                <x-input class="input-primary" name="username" label="Username" value="{{ old('username') }}" placeholder="Your Username..." icon="fas-user" required autofocus inline />
                <x-input class="input-primary" name="email" label="Email" value="{{ old('email') }}" placeholder="Your E-Mail..." icon="fas-at" required inline />

                <div class="text-center mt-3">
                    <div class="mb-2">
                        <x-button icon="fas-user-plus" type="submit" label="Register" class="btn-primary gap-2" />
                    </div>
                    <a class="link link-hover link-primary" href="{{ route('auth.login') }}">
                        Already an account?
                    </a>
                </div>
            </x-form>

        </div>
    </div>
</section>
@endsection
