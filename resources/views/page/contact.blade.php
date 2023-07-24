@extends('layouts.app')
{!! config(['app.title' => 'Contact']) !!}

@push('meta')
  <x-meta title="Contact" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto py-6">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            <div class="border border-gray-200 p-3 rounded-lg dark:bg-base-300 dark:border-gray-700">
                <h1 class="divider font-xetaravel text-3xl mb-5">
                    Contact
                </h1>
                <div class="flex justify-center mb-5">
                    <x-alert type="info" class="max-w-lg bg-base-200 dark:bg-base-200">
                        You have found a problem on the site or you just want to contact me ? Use the form below and i will answer you shortly !
                    </x-alert>
                </div>

                <div class="grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-6 px-3">
                        @if ((config('settings.contact.enabled')))
                            <x-form.form method="post" action="{{ route('page.contact') }}">
                                <x-form.text name="name" label="Name" placeholder="Your name..." required autofocus />
                                <x-form.email name="email" label="E-mail" placeholder="Your E-mail..." required />
                                <x-form.text name="subject" label="Subject" placeholder="Subject..." required autofocus />
                                <x-form.textarea name="message" label="Message" placeholder="Type your message here..." required></x-form.textarea>

                                <div class="form-control my-2">
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                                        </label>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary gap-2">
                                        <i class="fa-regular fa-paper-plane"></i>
                                        Send
                                    </button>
                                </div>
                            </x-form.form>
                        @else
                            <x-alert type="error">
                                The contact page is actually disabled, please try again later.
                            </x-alert>
                        @endif

                    </div>

                    <div class="col-span-12 lg:col-span-6 px-3">
                        <h2 class="font-xetaravel text-xl mb-3">
                            Contact
                        </h2>
                        <ul class="mb-8">
                            <li class="mb-2">
                                <i class="fa-solid fa-location-dot"></i>
                                Chalon sur Saône, 71100 France
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-phone"></i>
                                Secret
                            </li>
                            <li class="mb-2">
                                <i class="fa-solid fa-at"></i>
                                <a class="link link-hover link-primary" href="mailto:{{ config('xetaravel.site.contact_email') }}">{{ config('xetaravel.site.contact_email') }}</a>
                            </li>
                        </ul>

                        <h2 class="font-xetaravel text-xl mb-3">
                            Social
                        </h2>
                        <ul class="flex flex-rows gap-2">
                            <li>
                                <a href="https://facebook.com/emeric.fevre.37" target="_blank">
                                    <i class="fa-brands fa-square-facebook fa-2xl"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/FMT_ZoRo" target="_blank">
                                    <i class="fa-brands fa-square-twitter fa-2xl"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection