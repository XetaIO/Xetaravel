<x-layouts.app>
    <x-slot:title>
        Terms of Service
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="Terms of Service" />
    </x-slot:meta>

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="lg:container mx-auto py-6">
        <div class="col-span-12">
            <div class="bg-base-100 dark:bg-base-300 rounded-lg shadow-md py-3 px-5">

                {{-- Title --}}
                <div class="text-center mb-4">
                    <h1 class="divider text-3xl">
                        Terms of Service
                    </h1>
                </div>

                {{-- Last Update --}}
                <p class="mb-4">
                    Last update : April 17, 2025
                </p>

                {{-- Menu List --}}
                <h2 id="summary" class="font-semibold text-2xl group">
                    <a class="hidden group-hover:inline-block text-primary" href="#summary" title="Summary">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                    Summary
                </h2>

                <ol class="list-decimal pl-10">
                    <li class="mb-1">
                        <h3 class="font-semibold text-xl">
                            <a class="link link-hover link-primary" href="#general-information" title="General Information">
                                General Information
                            </a>
                        </h3>
                    </li>
                    <li class="mb-1">
                        <h3 class="font-semibold text-xl">
                            <a class="link link-hover link-primary" href="#account-terms" title="Account Terms">
                                Account Terms
                            </a>
                        </h3>
                    </li>
                    <li class="mb-1">
                        <h3 class="font-semibold text-xl">
                            <a class="link link-hover link-primary" href="#copyright-and-content-ownership" title="Copyright and Content Ownership">
                                Copyright and Content Ownership
                            </a>
                        </h3>
                    </li>
                    <li class="mb-1">
                        <h3 class="font-semibold text-xl">
                            <a class="link link-hover link-primary" href="#general-conditions" title="General Conditions">
                                General Conditions
                            </a>
                        </h3>
                    </li>
                    <li class="mb-1">
                        <h3 class="font-semibold text-xl">
                            <a class="link link-hover link-primary" href="#privacy-policy-terms" title="Privacy Policy Terms">
                                Privacy Policy Terms
                            </a>
                        </h3>

                        <ol class="list-decimal pl-10">
                            <li class="mb-1">
                                <h3 class="font-semibold text-xl">
                                    <a class="link link-hover link-primary" href="#privacy-policy-terms_cookies" title="Cookies">
                                        Cookies
                                    </a>
                                </h3>
                            </li>
                            <li class="mb-1">
                                <h3 class="font-semibold text-xl">
                                    <a class="link link-hover link-primary" href="#privacy-policy-terms_data-storage" title="Data Storage">
                                        Data Storage
                                    </a>
                                </h3>
                            </li>
                            <li class="mb-1">
                                <h3 class="font-semibold text-xl">
                                    <a class="link link-hover link-primary" href="#privacy-policy-terms_information-gathering-and-usage" title="Information Gathering and Usage">
                                        Information Gathering and Usage
                                    </a>
                                </h3>
                            </li>
                        </ol>
                    </li>
                </ol>


                <h2 id="general-information" class="font-semibold text-2xl mt-6 group">
                    <a class="hidden group-hover:inline-block text-primary" href="#general-information" title="General Information">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                    General Information
                </h2>
                <p>
                    Violation of any of the terms below will result in the termination of your Account. While Xetaravel prohibits such conduct and Content on the Service, you understand and agree that Xetaravel cannot be responsible for the Content posted on the Service and you nonetheless may be exposed to such materials. You agree to use the Service at your own risk.
                </p>

                <h2 id="account-terms" class="font-semibold text-2xl mt-6 group">
                    <a class="hidden group-hover:inline-block text-primary" href="#account-terms" title="Account Terms">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                        Account Terms
                </h2>
                <ol>
                    <li>
                        You must be 13 years or older to use this Service.
                    </li>
                    <li>
                        You must provide your username, a valid email address, and any other information requested in order to complete the signup process.
                    </li>
                    <li>
                        You are responsible for maintaining the security of your account and password. Xetaravel cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.
                    </li>
                    <li>
                            You are responsible for all Content posted and activity that occurs under your Account.
                    </li>
                    <li>
                        Selling your Account is totally prohibited and will result in the termination of your Account.
                    </li>
                    <li>
                        It is totally prohibited to share your Account with an other user. In that case, the Account shared will be immediately banned and you will lose all purchases made from your Account.
                    </li>
                    <li>
                        One person or legal entity may not maintain more than one Account.
                    </li>
                    <li>
                        When deleting your Account, all your Content will not be deleted directly. If you want all your Content to be deleted, please ask <a class="link link-hover link-primary" href="{{ route('page.contact') }}">here</a>.
                    </li>
                </ol>


                <h2 id="copyright-and-content-ownership" class="font-semibold text-2xl mt-6 group">
                    <a class="hidden group-hover:inline-block text-primary" href="#copyright-and-content-ownership" title="Copyright and Content Ownership">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                    Copyright and Content Ownership
                </h2>
                <ol>
                    <li>
                        The look and feel of the Service is copyright ©{{ date('Y', time()) }} Xetaravel. All rights reserved. You may not duplicate, copy, or reuse any portion of the HTML/CSS, Javascript, or visual design elements or concepts without express written permission from Xetaravel.
                    </li>
                    <li>
                        All trademarks, service marks, trade names, trade dress, product names and logos appearing on the site are the property of their respective owners.
                    </li>
                </ol>

                <h2 id="general-conditions" class="font-semibold text-2xl mt-6 group">
                    <a class="hidden group-hover:inline-block text-primary" href="#general-conditions" title="General Conditions">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                    General Conditions
                </h2>
                <ol>
                    <li>
                        Your use of the Service is at your sole risk. The service is provided on an "as is" and "as available" basis.
                    </li>
                    <li>
                        You understand that Xetaravel uses third-party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run the Service.
                    </li>
                    <li>
                        You must not modify, adapt or hack the Service or modify another website so as to falsely imply that it is associated with the Service, Xetaravel, or any other Xetaravel service.
                    </li>
                    <li>
                        You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by Xetaravel.
                    </li>
                    <li>
                        We may, but have no obligation to, remove Content and Accounts containing Content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party's intellectual property or these Terms of Service.
                    </li>
                    <li>
                        Verbal, physical, written or other abuse (including threats of abuse or retribution) of any Xetaravel customer, members, or staff will result in immediate account termination.
                    </li>
                    <li>
                        You understand that the technical processing and transmission of the Service, including your Content, may be transferred unencrypted.
                    </li>
                    <li>
                        Questions about the Terms of Service should be sent to <a href="mailto:emeric@xetaravel.com">emeric@xetaravel.com</a>.
                    </li>
                </ol>

                <h2 id="privacy-policy-terms" class="font-semibold text-2xl mt-6 group">
                    <a class="hidden group-hover:inline-block text-primary" href="#privacy-policy-terms" title="Privacy Policy Terms">
                        <x-icon name="fas-link" class="h-4 w-4" />
                    </a>
                    Privacy Policy Terms
                </h2>
                <ol class="list-decimal pl-10">
                    <li>
                         <h3 id="privacy-policy-terms_cookies" class="font-semibold text-xl group">
                            <a class="hidden group-hover:inline-block text-primary" href="#privacy-policy-terms_cookies" title="Cookies">
                                <x-icon name="fas-link" class="h-4 w-4" />
                            </a>
                            Cookies
                        </h3>

                        <ol class="list-decimal pl-10">
                            <li>
                                A cookie is a small amount of data, which often includes an anonymous unique identifier, that is sent to your browser from a web site's computers and stored on your computer's hard drive.
                            </li>
                            <li>
                                Cookies are required to use the Xetaravel service.
                            </li>
                            <li>
                                We use cookies to record current session information, but do not use permanent cookies. You are required to re-login to your Xetaravel account after a certain period of time has elapsed to protect you against others accidentally accessing your account contents.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <h3 id="privacy-policy-terms_data-storage" class="font-semibold text-xl group">
                            <a class="hidden group-hover:inline-block text-primary" href="#privacy-policy-terms_data-storage" title="Data Storage">
                                <x-icon name="fas-link" class="h-4 w-4" />
                            </a>
                            Data Storage
                        </h3>

                        <ol class="list-decimal pl-10">
                            <li>
                                Xetaravel uses third-party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run Xetaravel. Although Xetaravel owns the code, databases, and all rights to the Xetaravel application, you retain all rights to your data.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <h3 id="privacy-policy-terms_information-gathering-and-usage" class="font-semibold text-xl group">
                            <a class="hidden group-hover:inline-block text-primary" href="#privacy-policy-terms_information-gathering-and-usage" title="Information Gathering and Usage">
                                <x-icon name="fas-link" class="h-4 w-4" />
                            </a>
                            Information Gathering and Usage
                        </h3>

                        <ol class="list-decimal pl-10">
                            <li>
                                Xetaravel uses collected information for the following general purposes: products and services payments, billing, identification and authentication, services improvement, contact, and research.
                            </li>
                        </ol>
                    </li>
                </ol>


            </div>
        </div>
    </section>
</x-layouts.app>
