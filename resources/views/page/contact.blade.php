<x-layouts.app>
    <x-slot:title>
        Contact
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Contact" />
    </x-slot:meta>

    @push('scriptsTop')
        {!! NoCaptcha::renderJs() !!}
    @endpush


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
                <div class="p-3 rounded-lg bg-base-100 dark:bg-base-300 shadow-md">
                    <h1 class="divider text-3xl mb-5">
                        Contact
                    </h1>
                    <div class="flex justify-center mb-5">
                        <x-alert type="info" class="max-w-lg">
                            You have found a problem on the site or you just want to contact me ? Use the form below and i will answer you shortly !
                        </x-alert>
                    </div>

                    <div class="grid grid-cols-12">
                        <div class="col-span-12 lg:col-span-6 px-3">
                            @if (settings('contact_enabled'))
                                <x-form.form method="post" action="{{ route('page.contact') }}">
                                    <x-form.input name="name" label="Name" placeholder="Your name..." required autofocus />
                                    <x-form.input name="email" label="E-mail" placeholder="Your E-mail..." required />
                                    <x-form.input name="subject" label="Subject" placeholder="Subject..." required autofocus />
                                    <x-form.textarea name="message" label="Message" placeholder="Type your message here..." required />

                                    <div class="form-control my-2">
                                        {!! NoCaptcha::display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                                            </label>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <x-button class="btn-primary" label="Update" icon="fas-paper-plane" type="button" type="submit"  spinner />
                                    </div>
                                </x-form.form>
                            @else
                                <x-alert type="error">
                                    The contact page is actually disabled, please try again later.
                                </x-alert>
                            @endif
                        </div>

                        <div class="col-span-12 lg:col-span-6 px-3">
                            <h2 class="text-xl mb-3">
                                Contact
                            </h2>
                            <ul class="mb-8">
                                <li class="mb-2">
                                    <x-icon name="fas-location-dot" class="h-5 w-5"></x-icon>
                                    Chalon sur Saône, 71100 France
                                </li>
                                <li class="mb-2">
                                    <x-icon name="fas-phone" class="h-5 w-5"></x-icon>
                                    Secret
                                </li>
                                <li class="mb-2">
                                    <x-icon name="fas-at" class="h-5 w-5"></x-icon>
                                    <a class="link link-hover link-primary" href="mailto:{{ config('xetaravel.site.contact_email') }}">{{ config('xetaravel.site.contact_email') }}</a>
                                </li>
                            </ul>

                            <h2 class="text-xl mb-3">
                                Social
                            </h2>
                            <ul class="flex flex-rows gap-2">
                                <li>
                                    <a href="https://facebook.com/emeric.fevre.37" target="_blank">
                                        <x-icon name="fab-square-facebook" class="h-7 w-7"></x-icon>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://x.com/FMT_ZoRo" target="_blank">
                                        <x-icon name="fab-square-twitter" class="h-7 w-7"></x-icon>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
