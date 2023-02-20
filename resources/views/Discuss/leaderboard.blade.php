@extends('layouts.app')
{!! config(['app.title' => 'Leaderboard']) !!}

@push('meta')
  <x-meta title="Leaderboard" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-3 col-span-12 px-3">
            <div class="mb-5">
                <a href="{{ route('discuss.conversation.create') }}" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-pencil"></i>
                    Start a Discussion
                </a>
            </div>
            @include('Discuss::partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 px-3">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="col-span-12">
                    <div class="flex border border-gray-200 p-3 px-5 rounded-lg dark:bg-base-300 dark:border-gray-700">
                        <h5 class="text-2xl text-center mb-0 w-full">
                                Community Pillar
                        </h5>
                    </div>
                </div>
                @php
                    $i = 0;
                @endphp

                @foreach ($users as $user)
                    @php
                        $i++;
                    @endphp

                    @if ($i == 4)
                        <div class="col-span-12">
                            <div class="flex border border-gray-200 p-3 px-5 rounded-lg dark:bg-base-300 dark:border-gray-700">
                                <h5 class="text-2xl text-center mb-0 w-full">
                                        The most active in the Community
                                </h5>
                            </div>
                        </div>
                    @endif
                    <div class="lg:col-span-4 col-span-12">
                        <div class="relative text-center border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 p-3 pt-4 w-full">
                            <span class="absolute font-bold left-8 top-8 h-10 w-10 border border-gray-200 dark:border-gray-700  rounded-md p-1.5">
                                {{ $i }}
                            </span>
                            <a class="block" href="{{ $user->profile_url }}" title="{{ $user->username }}">
                                <div class="avatar relative">
                                    <div class="w-24 rounded ring ring-offset-base-100 ring-offset-2" style="{{ $i <=3 ? "--tw-ring-color: #f7a925;" : "" }}">
                                        <img class="{{ $badge->icon }}" src="{{ $user->avatar_small }}" alt="{{ $user->username }} avatar" />
                                        @if ($i <= 3)
                                            <span class="absolute -top-3 -right-3">
                                                <x-badge.icon.pillarofcommunity />
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <h5 class="text-2xl my-3">
                                {{ $user->username }}
                            </h5>
                            <div class="grid grid-cols-2 gap-5 justify-evenly mx-2">
                                <div class="rounded-md border border-gray-200 dark:border-gray-700 p-4 truncate">
                                    <h5 class="text-xl" style="{{ $i <= 3 ? "color:#f7a925" : "" }}">
                                        {{ $user->experiences_total }}
                                    </h5>
                                    <span class="">
                                        Experience
                                    </span>
                                </div>
                                <div class="rounded-md border border-gray-200 dark:border-gray-700 p-4">
                                    <h5 class="text-xl" style="{{ $i <= 3 ? "color:#f7a925" : "" }}">
                                        {{ $user->discuss_post_count }}
                                    </h5>
                                   <span class="">
                                    Posts
                                   </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection