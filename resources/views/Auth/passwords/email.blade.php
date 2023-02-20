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
                <h1 class="text-3xl font-xetaravel text-center mb-2">
                    Reset Password
                </h1>

                <x-form.form method="post" action="{{ route('users.auth.password.email') }}">
                    {!! Form::bsEmail('email', 'E-Mail Address', old('email'), [
                        'placeholder' => 'Your E-Mail...',
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

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-regular fa-paper-plane"></i>
                            Send Password Reset Link
                        </button>
                    </div>
                </x-form.form>
            </div>
        </div>
    </div>
</section>
@endsection
