@extends('layouts.app')
{!! config(['app.title' => 'Terms of Service']) !!}

@push('meta')
  <x-meta title="Terms of Service" />
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-4">
    <div class="col-md-12">
        <section class="terms">
            <div class="hr-divider">
                <div class="hr-divider-content hr-divider-heading font-xeta">
                    Terms of Service
                </div>
            </div>

            <p class="updated">
                Last update : November 1, 2021
            </p>


            <h4 id="summary">
                <a href="#summary">
                    <i class="fa fa-link"></i>
                </a>
                Summary
            </h4>

            <ol>
                <li>
                    <h5>
                        <a href="#general-information">General Information</a>
                    </h5>
                </li>
                <li>
                    <h5>
                        <a href="#account-terms">Account Terms</a>
                    </h5>
                </li>
                <li>
                    <h5>
                        <a href="#copyright-and-content-ownership">Copyright and Content Ownership</a>
                    </h5>
                </li>
                <li>
                    <h5>
                        <a href="#general-conditions">General Conditions</a>
                    </h5>
                </li>
                <li>
                    <h5>
                        <a href="#privacy-policy-terms">Privacy Policy Terms</a>
                    </h5>

                    <ol>
                        <li>
                            <h5>
                                <a href="#privacy-policy-terms_cookies">Cookies</a>
                            </h5>
                        </li>
                        <li>
                            <h5>
                                <a href="#privacy-policy-terms_data-storage">Data Storage</a>
                            </h5>
                        </li>
                        <li>
                            <h5>
                                <a href="#privacy-policy-terms_information-gathering-and-usage">Information Gathering and Usage</a>
                            </h5>
                        </li>
                    </ol>
                </li>
            </ol>


            <h4 id="general-information" class="mt-2">
                <a href="#general-information">
                    <i class="fa fa-link"></i>
                </a>
                General Information
            </h4>
            <p>
                Violation of any of the terms below will result in the termination of your Account. While Xetaravel prohibits such conduct and Content on the Service, you understand and agree that Xetaravel cannot be responsible for the Content posted on the Service and you nonetheless may be exposed to such materials. You agree to use the Service at your own risk.
            </p>

            <h4 id="account-terms" class="mt-2">
                <a href="#account-terms">
                    <i class="fa fa-link"></i>
                </a>
                    Account Terms
            </h4>
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
                    When deleting your Account, all your Content will not be deleted directly. If you want all your Content to be deleted, please ask <a href="{{ route('page.contact') }}">here</a>.
                </li>
            </ol>


            <h4 id="copyright-and-content-ownership" class="mt-2">
                <a href="#copyright-and-content-ownership">
                    <i class="fa fa-link"></i>
                </a>
                Copyright and Content Ownership
            </h4>
            <ol>
                <li>
                    The look and feel of the Service is copyright ©{{ date('Y', time()) }} Xetaravel. All rights reserved. You may not duplicate, copy, or reuse any portion of the HTML/CSS, Javascript, or visual design elements or concepts without express written permission from Xetaravel.
                </li>
                <li>
                    All trademarks, service marks, trade names, trade dress, product names and logos appearing on the site are the property of their respective owners.
                </li>
            </ol>

            <h4 id="general-conditions" class="mt-2">
                <a href="#general-conditions">
                    <i class="fa fa-link"></i>
                </a>
                General Conditions
            </h4>
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
                    Questions about the Terms of Service should be sent to <a href="mailto:zoro.fmt@gmail.com">zoro.fmt@gmail.com</a>.
                </li>
            </ol>

            <h4 id="privacy-policy-terms" class="mt-2">
                <a href="#privacy-policy-terms">
                    <i class="fa fa-link"></i>
                </a>
                Privacy Policy Terms
            </h4>
            <ol>
                <li>
                     <h5 id="privacy-policy-terms_cookies">
                        <a href="#privacy-policy-terms_cookies">
                            <i class="fa fa-link"></i>
                        </a>
                        Cookies
                    </h5>

                    <ol>
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
                    <h5 id="privacy-policy-terms_data-storage">
                        <a href="#privacy-policy-terms_data-storage">
                            <i class="fa fa-link"></i>
                        </a>
                        Data Storage
                    </h5>

                    <ol>
                        <li>
                            Xetaravel uses third-party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run Xetaravel. Although Xetaravel owns the code, databases, and all rights to the Xetaravel application, you retain all rights to your data.
                        </li>
                    </ol>
                </li>
                <li>
                    <h5 id="privacy-policy-terms_information-gathering-and-usage">
                        <a href="#privacy-policy-terms_information-gathering-and-usage">
                            <i class="fa fa-link"></i>
                        </a>
                        Information Gathering and Usage
                    </h5>

                    <ol>
                        <li>
                            Xetaravel uses collected information for the following general purposes: products and services payments, billing, identification and authentication, services improvement, contact, and research.
                        </li>
                    </ol>
                </li>
            </ol>


        </section>
    </div>
</div>

@endsection