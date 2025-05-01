@extends('layouts.app')
{!! config(['app.title' => 'Vérifiez votre E-mail !']) !!}

@push('meta')
    <x-meta title="Vérifiez votre E-mail !" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5 overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            <div class="flex flex-col items-center">
                @if (settings('user_email_verification_enabled'))
                    <div class="col-md-8 offset-md-2">
                        <h1 class="text-3xl text-center mb-2">
                            Verify your Email
                        </h1>

                        @if (session('resent'))
                            <x-alert type="success" class="max-w-lg mb-4">
                                A new verification link has been sent to your email address.
                            </x-alert>
                        @endif
                        <x-alert type="primary" class="max-w-lg mb-4">
                            <p>
                                Before proceeding, please verify your email and click on the verification link. (Also remember to look in the spam of your mailbox.)
                            </p>
                            <p>
                                If you did not receive the email, click the "Resend" button to request a new one.
                            </p>
                        </x-alert>

                        <x-form method="post" action="{{ route('auth.verification.resend') }}">
                            <x-input type="hidden" class="hidden" name="hash" value="{{ $hash }}" />

                            <div class="text-center mb-3">
                                <x-button icon="far-paper-plane" type="submit" label="Resend" class="btn-primary gap-2" />
                            </div>
                        </x-form>
                    </div>
                @else
                    <div>
                        <h1 class="text-3xl text-center mb-4">
                            Whoops
                        </h1>
                        <x-alert type="error" class="max-w-lg mb-4">
                            The email verification system is disabled at this time, please try again later.
                        </x-alert>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
