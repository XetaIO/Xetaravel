<header>

<!-- Navbar -->
<nav class="shadow-md bg-base-100 dark:bg-base-300 dark:text-slate-300">
    <div class="navbar lg:container mx-auto">
        <div class="flex-none lg:hidden tooltip tooltip-bottom" data-tip="Menu">
            <label for="xetaravel-drawer" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current md:h-6 md:w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </label>
        </div>
        <div class="lg:navbar-start lg:mx-0 max-lg:navbar-center max-lg:mx-auto">
            <a class="font-bold text-3xl" href="{{ route('page.index') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Xetaravel Logo" class="inline-block ">
                <span class="lg:hidden xl:inline-block">Xetaravel</span>
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="inline-flex flex-row" role="menu">
                <li>
                    <a class="gap-1 pl-4 my-3 flex group overflow-hidden text-lg align-middle" href="{{ route('page.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span
                            class="uppercase font-bold relative inline-block transition-transform duration-300
                                group-hover:text-primary group-hover:-translate-y-full
                                before:content-[attr(data-hover)] before:absolute before:top-full"
                            data-hover="Home"
                        >Home</span>
                    </a>
                </li>
                <li>
                    <a class="gap-1 pl-4 my-3 flex group overflow-hidden text-lg align-middle" href="{{ route('blog.article.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span
                            class="uppercase font-bold relative inline-block transition-transform duration-300
                                group-hover:text-primary group-hover:-translate-y-full
                                before:content-[attr(data-hover)] before:absolute before:top-full"
                            data-hover="Blog"
                        >Blog</span>
                    </a>
                </li>

                @if (settings('discuss_enabled') ||
                        (!settings('discuss_enabled') && !is_null(Auth::user()) && Auth::user()->hasPermissionTo('manage discuss conversation')))
                <li>
                    <a class="gap-1 pl-4 my-3 flex group overflow-hidden text-lg align-middle" href="{{ route('discuss.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        <span
                            class="uppercase font-bold relative inline-block transition-transform duration-300
                                group-hover:text-primary group-hover:-translate-y-full
                                before:content-[attr(data-hover)] before:absolute before:top-full"
                            data-hover="Discuss"
                        >Discuss</span>
                    </a>
                </li>
                @endif

                <li>
                    <a class="gap-1 pl-4 my-3 flex group overflow-hidden text-lg align-middle" href="{{ route('page.aboutme') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span
                            class="uppercase font-bold relative inline-block transition-transform duration-300
                                group-hover:text-primary group-hover:-translate-y-full
                                before:content-[attr(data-hover)] before:absolute before:top-full"
                            data-hover="About Me"
                        >About Me</span>
                    </a>
                </li>
                <li>
                    <a class="gap-1 pl-4 my-3 flex group overflow-hidden text-lg align-middle" href="{{ route('page.contact') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span
                            class="uppercase font-bold relative inline-block transition-transform duration-300
                                group-hover:text-primary group-hover:-translate-y-full
                                before:content-[attr(data-hover)] before:absolute before:top-full"
                            data-hover="Contact"
                        >Contact</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-end hidden lg:flex gap-2">
            {{-- Switch Dark Mode --}}
            <div class="tooltip tooltip-bottom" data-tip="Toggle theme">
                <x-theme-toggle />
            </div>

            @if (Auth::guest())
                <a href="{{ route('auth.login') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
                <a href="{{  route('auth.register')  }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                    Register
                </a>
            @else
                {{-- User Notifications Menu --}}
                <livewire:user.notification />


                {{-- User Avatar and Menu --}}
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ asset(Auth::user()->avatar_small) }}"  alt="User avatar" />
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        @can('access administration')
                            <li>
                                <div class="tooltip tooltip-top text-accent" data-tip="Access to the site administration.">
                                    <a href="{{ route('admin.page.index') }}" class="flex items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                          </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </div>

                            </li>
                            <div class="divider my-0"></div>
                        @endcan
                        <li>
                            <div class="tooltip tooltip-top" data-tip="Visit my profile !">
                                <a href="{{ Auth::user()->show_url }}" class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="tooltip tooltip-top" data-tip="Manage your account settings.">
                                <a href="{{ route('user.account.index') }}" class="flex items-center gap-4">
                                    <svg class="h-6 w-6 stroke-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l293.1 0c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1l-91.4 0zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"></path>
                                    </svg>
                                    <span>Account</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="tooltip tooltip-top" data-tip="Check your new and old notifications.">
                                <a href="{{ route('user.notification.index') }}" class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M351.8 367.3v-44.1C328.5 310.7 302.4 304 274.7 304H173.3c-95.73 0-173.3 77.65-173.3 173.4C.0005 496.5 15.52 512 34.66 512h378.7c11.86 0 21.82-6.337 28.07-15.43l-61.65-61.57C361.7 416.9 351.8 392.9 351.8 367.3zM224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM630.6 364.8L540.3 274.8C528.3 262.8 512 256 495 256h-79.23c-17.75 0-31.99 14.25-31.99 32l.0147 79.2c0 17 6.647 33.15 18.65 45.15l90.31 90.27c12.5 12.5 32.74 12.5 45.24 0l92.49-92.5C643.1 397.6 643.1 377.3 630.6 364.8zM447.8 343.9c-13.25 0-24-10.62-24-24c0-13.25 10.75-24 24-24c13.38 0 24 10.75 24 24S461.1 343.9 447.8 343.9z"/></svg>
                                    <span>Notifications</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="tooltip tooltip-top" data-tip="Manage the security of your account.">
                                <a href="{{ route('user.security.index') }}" class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M622.3 271.1l-115.1-45.01c-4.125-1.629-12.62-3.754-22.25 0L369.8 271.1C359 275.2 352 285.1 352 295.1c0 111.6 68.75 188.8 132.9 213.9c9.625 3.75 18 1.625 22.25 0C558.4 489.9 640 420.5 640 295.1C640 285.1 633 275.2 622.3 271.1zM496 462.4V273.2l95.5 37.38C585.9 397.8 530.6 446 496 462.4zM224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM320.6 310.3C305.9 306.3 290.6 304 274.7 304H173.3C77.61 304 0 381.7 0 477.4C0 496.5 15.52 512 34.66 512H413.3c3.143 0 5.967-1.004 8.861-1.789C369.7 469.8 324.1 400.3 320.6 310.3z"/></svg>
                                    <span>Security</span>
                                </a>
                            </div>
                        </li>


                        <div class="divider my-0"></div>
                        <li>
                            <div class="tooltip tooltip-top" data-tip="See you later !">
                                <a href="{{ route('auth.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-4 text-red-500">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </a>
                                <x-form method="post" action="{{ route('auth.logout') }}" id="logout-form" class="hidden"></x-form>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

</nav>
</header>
