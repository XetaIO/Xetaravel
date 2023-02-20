@extends('layouts.app')
{!! config(['app.title'  => 'Create your new Password']) !!}

@push('meta')
    <x-meta title="Create your new Password" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-xetaravel text-center mb-2">
                    Reset Password
                </h1>

                <x-form.form method="post" action="{{ route('users.auth.password.handlereset') }}">
                    {!! Form::hidden('token', $token) !!}

                    {!! Form::bsEmail('email', 'E-Mail Address', old('email'), [
                        'placeholder' => 'Your E-Mail...',
                        'required' => 'required'
                    ]) !!}

                    {!! Form::bsPassword('password', 'Password', [
                        'placeholder' => 'Your new Password...',
                        'required' => 'required'
                    ]) !!}

                    {!! Form::bsPassword('password_confirmation', 'Confirm Password', [
                        'placeholder' => 'Confirm your new Password...',
                        'required' => 'required'
                    ]) !!}

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-solid fa-rotate"></i>
                            Reset Password
                        </button>
                    </div>
                </x-form.form>
            </div>
        </div>
    </div>
</section>
@endsection
