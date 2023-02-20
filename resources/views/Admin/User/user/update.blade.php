@extends('layouts.admin')
{!! config(['app.title' => 'Edit ' . e($user->username)]) !!}

@push('meta')
    <x-meta title="Edit : {{ e($user->username) }}" />
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
            'height' => '200',
        ];
    @endphp
    @include('editor/partials/_signature', $signature)

    @php
        $biography = [
            'id' => 'biographyEditor',
            'height' => '250'
        ];
    @endphp
    @include('editor/partials/_biography', [$biography, $signature])

@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl font-xetaravel">
            Update <span class="font-bold">{{ e($user->username) }}</span>
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Update the user.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:col-span-3 text-center">
                    {{-- Avatar --}}
                    <div class="text-xl mb-5">
                        Avatar
                    </div>
                    <div class="avatar mb-5">
                        <div class=" h-36 w-36 rounded-xl ring ring-white ring-offset-base-100 ring-offset-2">
                            <img src="{{ $user->avatar_medium }}"  alt="{{ $user->username }} avatar"/>
                        </div>
                    </div>
                    <div class="mb-5">
                        <a class="btn btn-error gap-2" href="{{ route('admin.user.user.deleteavatar', $user->id) }}" onclick="event.preventDefault();document.getElementById('delete-avatar-form').submit();">
                            <i class="fa-solid fa-xmark"></i>
                            Delete avatar
                        </a>

                        <x-form.form method="delete" action="{{ route('admin.user.user.deleteavatar', $user->id) }}" id="delete-avatar-form" class="hidden"></x-form.form>
                    </div>

                    {{-- Delete User --}}
                    <label for="deleteModal" class="btn btn-error gap-2 mb-5">
                        <i class="fa-solid fa-xmark"></i>
                        Delete account
                    </label>
                </div>

                {{-- Edit User Information --}}
                <div class="col-span-12 lg:col-span-6">
                    <x-form.form method="put" action="{{ route('admin.user.user.update', $user->id) }}">

                        <x-form.text name="username" label="Username" value="{{ old('username', $user->username) }}" />

                        <x-form.text name="account[first_name]" label="First Name" value="{{ old('account[first_name]', optional($user->account)->first_name) }}" />

                        <x-form.text name="account[last_name]" label="Last Name" value="{{ old('account[last_name]', optional($user->account)->last_name) }}" />

                        <x-form.text name="email" label="Email" value="{{ old('email', $user->email) }}" />

                        <x-form.select  name="roles[]"  label="Roles" multiple required>
                            @foreach($roles as $id => $name)
                                <option {{ $user->hasRole($id) ? 'selected' : '' }} value="{{ $id }}" style="{{ $optionsAttributes[$id]['style'] }}">{{$name}}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.input-group name="account[facebook]" label="Facebook" data-span-class="dark:bg-[hsl(var(--n)/var(--tw-bg-opacity))] min-w-[180px]" data-input-group-verticale="input-group-vertical lg:flex-row" value="{{ old('account[facebook]', optional($user->account)->facebook) }}">
                            http://facebook.com/
                        </x-form.input-group>

                        <x-form.input-group name="account[twitter]" label="Twitter" data-span-class="dark:bg-[hsl(var(--n)/var(--tw-bg-opacity))] min-w-[180px]" data-input-group-verticale="input-group-vertical lg:flex-row" value="{{ old('account[twitter]', optional($user->account)->twitter) }}">
                            http://twitter.com/
                        </x-form.input-group>

                        <x-form.textarea name="account[biography]" editor="biographyEditor" label="Biography" class="hidden">
                            {{ optional($user->account)->biography }}
                        </x-form.textarea>

                        <x-form.textarea name="account[signature]" editor="signatureEditor" label="Signature" class="hidden">
                            {{ optional($user->account)->signature }}
                        </x-form.textarea>

                        <div class="mb-5">
                            <button type="submit" class="btn gap-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Update
                            </button>
                        </div>
                    </x-form.form>
                </div>

                {{-- Other User information --}}
                <div class="col-span-12 lg:col-span-3">
                    <div class="text-xl mb-5">
                        Others Informations
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <label class=" text-lg">
                            Last Login IP :
                        </label>
                        <div class="prose">
                            <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                {{ $user->last_login_ip }}
                            </code>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <label class=" text-lg">
                            Registered IP :
                        </label>
                        <div class="prose">
                            <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                {{ $user->register_ip }}
                            </code>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <label class=" text-lg">
                            Registered :
                        </label>
                        <div class="prose">
                            <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                            </code>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <label class=" text-lg">
                            Last Updated :
                        </label>
                        <div class="prose">
                            <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                {{ $user->updated_at->formatLocalized('%d %B %Y - %T') }}
                            </code>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Delete Account Modal --}}
    <input type="checkbox" id="deleteModal" class="modal-toggle" />
    <label for="deleteModal" class="modal cursor-pointer">
        <label class="modal-box relative">
            <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <h3 class="font-bold text-lg">
                Delete <strong>{{ $user->username }}</strong> Account
            </h3>
            <p>
                Are you sure you want delete this account ? <span class="font-bold text-red-500">This operation is not reversible.</span>
            </p>

            <x-form.form method="delete" action="{{ route('admin.user.user.delete', $user->id) }}">

                <x-form.input-group name="password" type="password" label="Your password">
                    <i class="fa-solid fa-lock"></i>
                </x-form.input-group>


                <div class="modal-action">
                    <button type="submit" class="btn btn-error gap-2">
                        Yes, I confirm !
                    </button>
                    <label for="deleteModal" class="btn">Close</label>
                </div>
            </x-form.form>
        </label>
    </label>
</section>
@endsection
