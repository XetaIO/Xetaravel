@extends('layouts.app')
{!! config(['app.title' => 'Join us !']) !!}

@push('meta')
    <x-meta title="Join us !" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
                @if (config('settings.user.register.enabled'))
                    <div>
                        <h1 class="text-3xl font-xetaravel text-center mb-2">
                            Register
                        </h1>

                        <x-form.form method="post" action="{{ route('users.auth.register') }}">
                            {!! Form::bsText('username', 'Username', old('username'), [
                                'placeholder' => 'Your Username...',
                                'required' => 'required',
                                'autofocus'
                            ]) !!}

                            {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                                'placeholder' => 'Your E-Mail...',
                                'required' => 'required'
                            ]) !!}

                            {!! Form::bsPassword('password', 'Password', [
                                'placeholder' => 'Your Password...',
                                'required' => 'required'
                            ]) !!}

                            {!! Form::bsPassword('password_confirmation', 'Confirm Password', [
                                'placeholder' => 'Confirm your Password...',
                                'required' => 'required'
                            ]) !!}

                            <div class="form-control my-2">
                                {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                                    </label>
                                @endif
                            </div>

                            {!! Form::bsCheckbox("terms", null, false, "By clicking on \"Register\", you accept that you have read and understand the Terms.") !!}

                            <div class="text-center">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary gap-2">
                                        <i class="fa-solid fa-user-plus"></i>
                                        Register
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <a class="btn gap-2" href="{{ route('auth.driver.redirect', ['driver' => 'github']) }}">
                                        Register with Github <i class="fa-brands fa-github"></i>
                                    </a>
                                </div>
                                <div >
                                    <a class="link link-hover link-primary" href="{{ route('users.auth.login') }}">
                                        Already an account?
                                    </a>
                                </div>
                            </div>
                        </x-form.form>
                    </div>
                @else
                    <div>
                        <h1 class="text-3xl font-xetaravel text-center mb-4">
                            Whoops
                        </h1>
                        <x-alert type="error" class="max-w-lg mb-4">
                            The registration system is currently disabled, please try again later.
                        </x-alert>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
