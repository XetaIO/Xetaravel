@extends('layouts.app')
{!! config(['app.title' => 'Security']) !!}

@push('meta')
  <x-meta title="Security" />
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
            @include('user.partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                <h2 class="divider text-2xl">
                    Sessions
                </h2>
                <p class="mb-6">
                    This is a list of devices that are logged into your account.
                </p>

               <ul>
                @foreach ($sessions as $session)
                    <li class="flex items-center border border-gray-400  rounded p-5 mb-5 {{ $sessionId == $session->id ? 'current' : '' }}">
                        <span class=" bg-green-500 rounded-full shadow-[0_0_10px_rgb(34,197,94)] h-2 w-2 mr-3 mt-2"></span>

                        <span class="tooltip mr-3 mt-1" data-tip="{{ $session->user_agent }}">
                            @if ($session->infos['device_type'] === 'phone')
                                <x-icon name="fas-mobile-screen-button" class="w-9 h-9" />
                            @elseif ($session->infos['device_type'] === 'tablet')
                                <x-icon name="fas-tablet-screen-button" class="w-9 h-9" />
                            @else
                                <x-icon name="fas-desktop" class="w-9 h-9" />
                            @endif
                        </span>

                        <div class="w-full">
                            <p class="mb-2 font-bold">
                                    @if ($sessionId == $session->id)
                                        Your current session
                                    @else
                                        Other session
                                    @endif
                                    <span>{{ $session->ip_address }}</span>
                            </p>

                            <p class="mb-2">
                                <span class="font-bold">{{ $session->infos['browser'] }} {{ $session->infos['browser_version'] }}</span>
                                on {{ $session->infos['platform'] }} {{ $session->infos['platform_version'] }}
                            </p>

                            <p class="mb-2">
                                <span class="font-bold">Last seen on</span>
                                {{ $session?->url }}
                            </p>

                            <p class="mb-2">
                                <span class="font-bold">Last seen</span>
                                {{ $session->updated_at }}
                            </p>

                            <p class="mb-2">
                                <span class="font-bold">Created</span>
                                {{ $session->created_at }}
                            </p>
                        </div>
                    </li>
                @endforeach
               </ul>
            </section>

        </div>
    </div>
</section>
@endsection
