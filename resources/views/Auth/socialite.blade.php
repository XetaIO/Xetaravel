@extends('layouts.app')
{!! config(['app.title' => 'Join us !']) !!}

@push('meta')
    <x-meta title="Join us !" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
                <x-alert type="error" class="max-w-lg mb-4">
                    There are some errors while registering your account. Please fix these errors before to continue.
                </x-alert>
                <h1 class="text-3xl font-xetaravel text-center mb-2">
                    Register with {{ Str::title(session('socialite.driver')) }}
                </h1>

                <div class="">
                    <x-form.form method="post" action="{{ route('auth.driver.register.validate', ['driver' => session('socialite.driver')]) }}">
                        {!! Form::bsText('username', 'Username', old('username'), [
                            'placeholder' => 'Your Username...',
                            'required' => 'required',
                            'autofocus'
                        ]) !!}

                        {!! Form::bsEmail('email', 'E-Mail', old('email'), [
                            'placeholder' => 'Your E-Mail...',
                            'required' => 'required'
                        ]) !!}

                        <div class="text-center mt-3">
                            <div class="mb-2">
                                <button type="submit" class="btn btn-primary gap-2">
                                    <i class="fa-solid fa-user-plus"></i>
                                    Register
                                </button>
                            </div>
                            <a class="link link-hover link-primary" href="{{ route('users.auth.login') }}">
                                Already an account?
                            </a>
                        </div>
                    </x-form.form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
