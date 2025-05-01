@extends('layouts.app')
{!! config(['app.title'  => 'Create your new Password']) !!}

@push('meta')
    <x-meta title="Create your new Password" />
@endpush

@section('content')
<section class="mx-auto">
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
    <div class="flex flex-col items-center">
        <div class="p-8 shadow-lg rounded-lg bg-base-100 dark:bg-base-300">
            <h1 class="text-3xl text-center mb-2">
                Reset Password
            </h1>

            <x-form method="post" action="{{ route('auth.password.handlereset') }}">
                <x-input type="hidden" class="hidden" name="token" value="{{ $token }}" />
                <x-input class="input-primary" name="email" label="Email" value="{{ old('email') }}" placeholder="Your E-Mail..." icon="fas-at" required autofocus inline />
                <x-password class="input-primary" name="password" label="Password" placeholder="Your Password..." required inline />
                <x-password class="input-primary" name="password_confirmation" label="Confirm Password" placeholder="Confirm your Password..." required inline />

                <div class="text-center mb-3">
                    <x-button icon="fas-rotate" type="submit" label="Reset Password" class="btn-primary gap-2" />
                </div>
            </x-form>
        </div>
    </div>
    <div class="sm:h-[110px] h-[130px] md:h-[160px]"></div>
</section>
@endsection
