@extends('layouts.app')
{!! config(['app.title' => 'Reset your password']) !!}

@push('meta')
    <x-meta title="Reset your password" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
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
                </x-form>
            </div>
        </div>
    </div>
</section>
@endsection
