<aside class="drawer-side z-1">
    <label for="xetaravel-drawer" class="drawer-overlay"></label>
    <div class="menu w-70 bg-base-100 dark:bg-base-300 min-h-full shadow-md">
        <div class="p-4">
            <a class="flex gap-1 items-center justify-center font-bold text-3xl hover:bg-transparent focus:bg-transparent active:bg-transparent" href="{{ route('page.index') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Xetaravel Logo" class="inline-block ">
                <span>Xetaravel</span>
            </a>
            {{-- Switch Dark Mode --}}
            <div class="flex justify-center tooltip tooltip-bottom lg:hidden" data-tip="Toggle theme">
                <x-theme-toggle id="-sidebar"/>
            </div>
        </div>

        <div class="divider px-4 my-0"></div>

        <ul class="p-4" role="list">
            <li class="menu-title">
                <span>Administration</span>
            </li>
            <li>
                <a @class([
                    'py-3',
                    'menu-active' => request()->route()->getName() === 'admin.page.index'])
                    href="{{ route('admin.page.index') }}">
                    <x-icon name="fas-gauge" />
                    Dashboard
                </a>
            </li>

            @can('manage blog article')
                <li class="menu-title">
                    <span>Blog</span>
                </li>
                <li>
                    <ul>
                        <li>
                            <a @class([
                              'py-3',
                              'menu-active' => request()->route()->getName() === 'admin.blog.article.index'])
                               href="{{ route('admin.blog.article.index') }}">
                                <x-icon name="far-newspaper" />
                                Manage Articles
                            </a>
                        </li>
                        <li>
                            <a @class([
                              'py-3',
                              'menu-active' => request()->route()->getName() === 'admin.blog.category.index'])
                               href="{{ route('admin.blog.category.index') }}">
                                <x-icon name="fas-tags" />
                                Manage Categories
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('manage discuss category')
                <li class="menu-title">
                    <span>Discuss</span>
                </li>
                <li>
                    <a @class([
                      'py-3',
                      'menu-active' => request()->route()->getName() === 'admin.discuss.category.index'])
                       href="{{ route('admin.discuss.category.index') }}">
                        <x-icon name="fas-tags" />
                        Manage Categories
                    </a>
                </li>
            @endcan

            @can('manage user')
                <li class="menu-title">
                    <span>Users</span>
                </li>
                <li>
                    <a @class([
                      'py-3',
                      'menu-active' => request()->route()->getName() === 'admin.user.index'])
                       href="{{ route('admin.user.index') }}">
                        <x-icon name="fas-users" />
                        Manage Users
                    </a>
                </li>
            @endcan

            @canany(['manage role', 'manage permission'])
                <li class="menu-title">
                    <span>Roles & Permissions</span>
                </li>
            <li >
                <ul>
                    @can('manage role')
                    <li>
                        <a @class([
                          'py-3',
                          'menu-active' => request()->route()->getName() === 'admin.role.index'])
                           href="{{ route('admin.role.index') }}">
                            <x-icon name="fas-user-tie" />
                            Manage Roles
                        </a>
                    </li>
                    @endcan
                    @can('manage permission')
                        <li>
                            <a @class([
                              'py-3',
                              'menu-active' => request()->route()->getName() === 'admin.permission.index'])
                               href="{{ route('admin.permission.index') }}">
                                <x-icon name="fas-user-shield" />
                                Manage Permissions
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can('manage setting')
                <li class="menu-title">
                    <span>Settings</span>
                </li>
                <li>
                    <a @class([
                      'py-3',
                      'menu-active' => request()->route()->getName() === 'admin.setting.index'])
                       href="{{ route('admin.setting.index') }}">
                        <x-icon name="fas-wrench" />
                        Manage Setting
                    </a>
                </li>
            @endcan
        </ul>

        <div class="divider px-4 my-0 lg:hidden"></div>

            <!-- User Menu-->
        <div class="group flex items-center lg:hidden px-4 w-full h-16 min-h-16 mt-auto shadow-md bg-slate-300 dark:bg-gray-700">
            <div class="dropdown dropdown-hover dropdown-right dropdown-top">
                <label tabindex="0" class="avatar btn btn-ghost btn-circle">
                <div class="w-10 rounded-full">
                    <img src="{{ asset(Auth::user()->avatar_small) }}"  alt="User avatar" class="rounded-full" />
                </div>
            </label>
                <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                    @can('access administration')
                        <li>
                            <a  href="{{ route('admin.page.index') }}" class="hover:shadow text-accent active:bg-accent active:text-[color:hsl(var(--pc))] rounded-[var(--rounded-btn)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                <span >Dashboard</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ Auth::user()->show_url }}"  class="hover:shadow rounded-[var(--rounded-btn)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.notification.index') }}"  class="hover:shadow rounded-[var(--rounded-btn)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M351.8 367.3v-44.1C328.5 310.7 302.4 304 274.7 304H173.3c-95.73 0-173.3 77.65-173.3 173.4C.0005 496.5 15.52 512 34.66 512h378.7c11.86 0 21.82-6.337 28.07-15.43l-61.65-61.57C361.7 416.9 351.8 392.9 351.8 367.3zM224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM630.6 364.8L540.3 274.8C528.3 262.8 512 256 495 256h-79.23c-17.75 0-31.99 14.25-31.99 32l.0147 79.2c0 17 6.647 33.15 18.65 45.15l90.31 90.27c12.5 12.5 32.74 12.5 45.24 0l92.49-92.5C643.1 397.6 643.1 377.3 630.6 364.8zM447.8 343.9c-13.25 0-24-10.62-24-24c0-13.25 10.75-24 24-24c13.38 0 24 10.75 24 24S461.1 343.9 447.8 343.9z"/></svg>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.security.index') }}"  class="hover:shadow rounded-[var(--rounded-btn)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 640 512"><path d="M622.3 271.1l-115.1-45.01c-4.125-1.629-12.62-3.754-22.25 0L369.8 271.1C359 275.2 352 285.1 352 295.1c0 111.6 68.75 188.8 132.9 213.9c9.625 3.75 18 1.625 22.25 0C558.4 489.9 640 420.5 640 295.1C640 285.1 633 275.2 622.3 271.1zM496 462.4V273.2l95.5 37.38C585.9 397.8 530.6 446 496 462.4zM224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM320.6 310.3C305.9 306.3 290.6 304 274.7 304H173.3C77.61 304 0 381.7 0 477.4C0 496.5 15.52 512 34.66 512H413.3c3.143 0 5.967-1.004 8.861-1.789C369.7 469.8 324.1 400.3 320.6 310.3z"/></svg>
                            <span>Security</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="hover:shadow text-red-500 active:text-[color:hsl(var(--pc))] active:bg-red-500 rounded-[var(--rounded-btn)]">
                            <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col items-start">
                <span class="ml-2 font-bold text-primary">{{ Auth::user()->full_name }}</span>
                <small class="ml-2 ">{{  Auth::user()->email }}</small>
            </div>
        </div>

    </div>
</aside>
