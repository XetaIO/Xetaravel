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
            @include('partials.user._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                <h2 class="divider text-2xl font-xetaravel">
                    Change your E-mail
                </h2>

                <x-form.form method="put" action="{{ route('users.user.settings') }}">
                    <x-form.hidden name="type" value="email" />

                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-6">
                            <x-form.static label="E-mail">
                                {{ Auth::user()->email }}
                            </x-form.static>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-form.email name="email" label="New E-mail" placeholder="Your new E-mail..." required />
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Save
                        </button>
                    </div>
                </x-form.form>
            </section>

            <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
            @if (is_null(Auth::user()->password))
                <h2 class="divider text-2xl font-xetaravel">
                    Change your Password
                </h2>

                <x-form.form method="put" action="{{ route('users.user.settings') }}">
                    <x-form.hidden name="type" value="password" />
                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-4">
                            <x-form.password name="oldpassword" label="Current Password" placeholder="Your current Password..." required/>
                        </div>
                        <div class="col-span-12 lg:col-span-4">
                            <x-form.password name="password" label="New Password" placeholder="Your new Password..." required/>
                        </div>
                        <div class="col-span-12 lg:col-span-4">
                            <x-form.password name="password_confirmation" label="Confirm New Password" placeholder="Confirm your new Password..." required/>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-solid fa-rotate"></i>
                            Change
                        </button>
                    </div>
                </x-form.form>
            @else
                <h2 class="divider text-2xl font-xetaravel">
                    Create a Password
                </h2>

                <x-alert type="info" class="max-w-3xl bg-base-200 dark:bg-base-200 mx-auto mb-7">
                    With a registration via Github, you have the possibility to define a password to <span class="font-bold">connect also with your email and password</span> in addition to the connection via Github!
                </x-alert>

                <x-form.form method="put" action="{{ route('users.user.settings') }}">
                    <x-form.hidden name="type" value="newpassword" />

                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-6">
                            <x-form.password name="password" label="New Password" placeholder="Your new Password..." required/>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-form.password name="password_confirmation" label="Confirm New Password" placeholder="Confirm your new Password..." required/>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-solid fa-lock"></i>
                            Create
                        </button>
                    </div>
                </x-form.form>
            @endif
            </section>

            <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                <h2 class="divider text-2xl font-xetaravel">
                    Delete your Account
                </h2>

                <div class="text-center">
                    <label class="deleteAccountModal btn btn-error gap-2" for="deleteAccountModal">
                        <i class="fa-solid fa-trash-can"></i>
                        Delete my Account
                    </label>
                </div>

                <input type="checkbox" id="deleteAccountModal" class="modal-toggle" />
                <label for="deleteAccountModal" class="modal cursor-pointer">
                    <label class="modal-box relative">
                        <label for="deleteAccountModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                        <h3 class="font-bold text-lg">
                            Delete my Account
                        </h3>
                        <x-form.form method="delete" action="{{ route('users.user.delete') }}">
                            <p class="mb-7">
                                    Are you sure you want delete your account ? <span class="font-bold">This operation is not reversible.</span>
                            </p>
                            <x-form.input-group name="password" type="password" placeholder="Your Password..." required>
                                <i class="fa-solid fa-lock"></i>
                            </x-form.input-group>

                            <div class="modal-action">
                                <button type="submit" class="btn btn-error gap-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Yes, I confirm !
                                </button>
                                <label for="deleteAccountModal" class="btn">Close</label>
                            </div>
                        </x-form.form>
                    </label>
                </label>

            </section>

        </div>
    </div>
</section>
@endsection
