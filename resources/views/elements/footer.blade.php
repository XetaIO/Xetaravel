<footer class="footer sm:footer-horizontal p-10 bg-base-200 text-base-content">

        <nav>
            <h6 class="footer-title">Utils</h6>
            @guest
                <a href="{{  route('users.auth.register')  }}" class="btn btn-outline px-4 py-2 rounded mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                    Register
                </a>
                <a href="{{ route('users.auth.login') }}" class="btn btn-outline px-4 py-2 rounded mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endguest
            <a class="link link-hover" href="{{ route('blog.article.index') }}">
                Blog
            </a>
            <a class="link link-hover" href="{{ route('discuss.index') }}">
                Discuss
            </a>
        </nav>

        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover" href="{{ route('page.terms') }}">
                Terms
            </a>
            <a class="link link-hover" href="{{ route('page.contact') }}">
                Contact
            </a>
            <a href="{{ config('xetaravel.site.github_url') }}" target="_blank" class="tooltip tooltip-top flex gap-1" data-tip="Source Code available on Github">
                <svg xmlns="http://www.w3.org/2000/svg"  class="h-5 w-5 fill-current" viewBox="0 0 480 512"><path d="M186.1 328.7c0 20.9-10.9 55.1-36.7 55.1s-36.7-34.2-36.7-55.1 10.9-55.1 36.7-55.1 36.7 34.2 36.7 55.1zM480 278.2c0 31.9-3.2 65.7-17.5 95-37.9 76.6-142.1 74.8-216.7 74.8-75.8 0-186.2 2.7-225.6-74.8-14.6-29-20.2-63.1-20.2-95 0-41.9 13.9-81.5 41.5-113.6-5.2-15.8-7.7-32.4-7.7-48.8 0-21.5 4.9-32.3 14.6-51.8 45.3 0 74.3 9 108.8 36 29-6.9 58.8-10 88.7-10 27 0 54.2 2.9 80.4 9.2 34-26.7 63-35.2 107.8-35.2 9.8 19.5 14.6 30.3 14.6 51.8 0 16.4-2.6 32.7-7.7 48.2 27.5 32.4 39 72.3 39 114.2zm-64.3 50.5c0-43.9-26.7-82.6-73.5-82.6-18.9 0-37 3.4-56 6-14.9 2.3-29.8 3.2-45.1 3.2-15.2 0-30.1-.9-45.1-3.2-18.7-2.6-37-6-56-6-46.8 0-73.5 38.7-73.5 82.6 0 87.8 80.4 101.3 150.4 101.3h48.2c70.3 0 150.6-13.4 150.6-101.3zm-82.6-55.1c-25.8 0-36.7 34.2-36.7 55.1s10.9 55.1 36.7 55.1 36.7-34.2 36.7-55.1-10.9-55.1-36.7-55.1z"/></svg>
                Source Code
            </a>

            @if (config('xetaravel.version'))
                <span class="link link-hover pb-4">
                    <small>Version : {{ config('xetaravel.version') }}</small>
                </span>
            @endif
        </nav>

        <nav>
            <h6 class="footer-title">Newsletter</h6>

            <fieldset class="w-80">
                <label>Enter your email address</label>

                <x-form method="post" action="{{ route('newsletter.subscribe') }}">
                    <div class="join">
                        <input
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="email@gmail.com"
                            class="input input-bordered join-item"
                            required />
                        <button type="submit" class="btn btn-primary join-item">Subscribe</button>
                    </div>
                </x-form>
            </fieldset>
        </nav>
</footer>
<footer class="footer footer-horizontal footer-center p-10 bg-base-200 text-base-content">
    <hr class=" border-gray-200 sm:mx-auto dark:border-gray-700 my-2 h-0.5 w-full" />

    <div class="lg:container lg:text-center w-full mx-auto">
        <div class="w-full">
            &copy; {{ date('Y', time()) }} {{ config('app.name') }}. All rights reserved.
        </div>
        <div class="w-full">
            <i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-heart" style="color: #fa6c65"></i> and <i class="fa fa-coffee" style="color: #826644"></i> by <a href="https://github.com/Xety" target="_blank" class="link link-hover link-primary">@Emeric</a>
        </div>
        <div class="w-full">
            Hosted with <a href="https://forge.laravel.com" target="_blank" class="link link-hover link-primary">Laravel Forge</a> and <a href="https://www.digitalocean.com" target="_blank" class="link link-hover link-primary">DigitalOcean</a>
        </div>
    </div>
</footer>
