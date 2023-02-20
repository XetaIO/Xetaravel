@extends('layouts.app')
{!! config(['app.title' => 'My account']) !!}

@push('meta')
    <x-meta title="My account" />
@endpush

@push('style')
    {!! editor_css() !!}
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $signature = [
            'id' => 'signatureEditor',
            'height' => '350',
        ];
    @endphp
    @include('editor/partials/_signature', $signature)

    @php
        $biography = [
            'id' => 'biographyEditor',
            'height' => '350'
        ];
    @endphp
    @include('editor/partials/_biography', $biography)
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
                <h2 class="divider text-2xl font-xetaravel mb-6">
                    My Account
                </h2>

                <x-form.form method="put" action="{{ route('users.account.update') }}" enctype="multipart/form-data">
                    <div class="grid grid-cols-12 gap-4 mb-7">
                        <div class="col-span-12 lg:col-span-6">
                            <div class="form-control items-center">

                                <div class="avatar mb-5">
                                    <div class=" w-52 rounded-xl ring ring-white ring-offset-base-100 ring-offset-2">
                                        <img src="{{ $user->avatar_medium }}"  alt="{{ $user->username }} avatar"/>
                                    </div>
                                </div>

                                <x-form.file name="avatar" class="max-w-sm" />
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-form.text name="first_name" label="First Name" placeholder="Your First Name..." value="{{ $user->account->first_name }}" />
                            <x-form.text name="last_name" label="Last Name" placeholder="Your Last Name..." value="{{ $user->account->last_name }}" />
                        </div>
                    </div>

                    <x-form.input-group name="facebook" label="Facebook" data-span-class="dark:bg-[hsl(var(--n)/var(--tw-bg-opacity))] min-w-[180px]" data-input-group-verticale="input-group-vertical lg:flex-row" placeholder="Your Facebook here..." value="{{ $user->account->facebook }}">
                        http://facebook.com/
                    </x-form.input-group>

                    <x-form.input-group name="twitter" label="Twitter" data-span-class="dark:bg-[hsl(var(--n)/var(--tw-bg-opacity))] min-w-[180px]" data-input-group-verticale="input-group-vertical lg:flex-row" placeholder="Your Twitter here..." value="{{ $user->account->twitter }}">
                        http://twitter.com/
                    </x-form.input-group>

                    <x-form.textarea name="biography" editor="biographyEditor" label="Biography" class="hidden">
                        {{ $user->account->biography }}
                    </x-form.textarea>

                    <x-form.textarea name="signature" editor="signatureEditor" label="Signature" class="hidden">
                        {{ $user->account->signature }}
                    </x-form.textarea>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Save
                        </button>
                    </div>
                </x-form.form>
            </section>
        </div>
    </div>
</section>
@endsection
