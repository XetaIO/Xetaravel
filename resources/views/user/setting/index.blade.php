@extends('layouts.app')
{!! config(['app.title' => 'Settings']) !!}

@push('meta')
  <x-meta title="Settings" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-12 gap-8">

        <div class="lg:col-span-3 col-span-12 mx-3 lg:mx-0">
            @include('user.partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <section class="rounded-lg bg-base-100 dark:bg-base-300 shadow-md py-4 px-8 mb-10">
                <h2 class="divider text-2xl">
                    Change your E-mail
                </h2>

                <x-form method="put" action="{{ route('user.email.update') }}">
                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-6">
                            <x-input label="E-mail" value="{{ Auth::user()->email }}" disabled/>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-input name="email" label="New E-mail" placeholder="Your new E-mail..." required />
                        </div>
                    </div>

                    <div class="text-center">
                        <x-button icon="far-floppy-disk" type="submit" label="Save" class="btn-primary gap-2" />
                    </div>
                </x-form>
            </section>

            <section class="rounded-lg bg-base-100 dark:bg-base-300 shadow-md py-4 px-8 mb-10">
            @if (!is_null(Auth::user()->password))
                <h2 class="divider text-2xl">
                    Change your Password
                </h2>

                <x-form method="put" action="{{ route('user.password.update') }}">
                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-4">
                            <x-password name="current_password" label="Current Password" placeholder="Your current Password..." required />
                        </div>
                        <div class="col-span-12 lg:col-span-4">
                            <x-password name="password" label="New Password" placeholder="Your new Password..." required />
                        </div>
                        <div class="col-span-12 lg:col-span-4">
                            <x-password name="password_confirmation" label="Confirm New Password" placeholder="Confirm your new Password..." required />
                        </div>
                    </div>

                    <div class="text-center">
                        <x-button icon="fas-rotate" type="submit" label="Change" class="btn-primary gap-2" />
                    </div>
                </x-form>
            @else
                <h2 class="divider text-2xl">
                    Create a Password
                </h2>

                <x-alert type="info" class="max-w-3xl bg-base-200 dark:bg-base-200 mx-auto mb-7">
                    With a registration via Github, you have the possibility to define a password to <span class="font-bold">connect also with your email and password</span> in addition to the connection via Github!
                </x-alert>

                <x-form method="post" action="{{ route('user.password.create') }}">
                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-6">
                            <x-password name="password" label="New Password" placeholder="Your new Password..." required />
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-password name="password_confirmation" label="Confirm New Password" placeholder="Confirm your new Password..." required />
                        </div>
                    </div>

                    <div class="text-center">
                        <x-button icon="fas-rotate" type="submit" label="Create" class="btn-primary gap-2" />
                    </div>
                </x-form>
            @endif
            </section>

            <section class="rounded-lg bg-base-100 dark:bg-base-300 shadow-md py-4 px-8 mb-10">
                <h2 class="divider text-2xl">
                    Delete your Account
                </h2>

                <div class="text-center">
                    <x-button class="btn-error" label="Delete my Account" icon="fas-trash-can" onclick="deleteAccountModal.showModal()" />
                </div>

                <dialog id="deleteAccountModal" class="modal">
                    <div class="modal-box">
                        <form method="dialog" tabindex="-1">
                            <x-button class="btn-circle btn-sm btn-ghost absolute end-2 top-2 z-[999]" icon="fas-xmark" type="submit" tabindex="-1" />
                        </form>
                        <h3 class="font-bold text-lg mb-4">
                            Delete my Account
                        </h3>

                        <x-form method="delete" action="{{ route('user.delete') }}">
                            <p class="mb-4">
                                Are you sure you want delete your account ? <span class="font-bold">This operation is not reversible.</span>
                            </p>
                            <x-password name="password" label="Password" placeholder="Your Password..." required />

                            <div class="modal-action">
                                <x-button icon="fas-trash-can" type="submit" label="Yes, I confirm !" class="btn-error gap-2" />
                            </div>
                        </x-form>
                    </div>
                    <form class="modal-backdrop" method="dialog">
                        <button type="submit">close</button>
                    </form>
                </dialog>
            </section>

        </div>
    </div>
</section>
@endsection
