<x-layouts.app>
    <x-slot:title>
        {{ $user->username }}  profile
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="{{ $user->username }}  profile" />
    </x-slot:meta>

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    {{-- User Profile --}}
    <section class="lg:container mx-auto py-6">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                <h1 class="text-2xl text-center font-bold uppercase mb-5">
                    {{ e($user->username) }} profile
                </h1>
            </div>
            <div class="col-span-12 mb-3 mx-3 lg:mx-0">
                @if (Auth::user() && $user->id == Auth::id())
                    <div class="text-right">
                        <x-button link="{{ route('user.account.index') }}" icon="fas-pencil" label="Edit my profile" class="btn-outline-primary btn-sm gap-2" />

                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-4 mx-3 lg:mx-0">
                <div
                    class="flex flex-col sm:flex-row text-center shadow-md bg-white dark:bg-base-300 rounded-lg p-6 w-full h-full">

                    <div class="w-full md:w-1/2">
                        {{--  User Avatar --}}
                        <div class="relative avatar {{ $user->online ? 'avatar-online' : 'avatar-offline' }} m-2">
                            <figure
                                class="h-24 w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible"
                                data-tip="{{ $user->username }} is {{ $user->online ? 'online' : 'offline' }}">
                                <img class="rounded-full" src="{{ $user->avatar_small }}"
                                     alt="{{ $user->full_name }} avatar" />
                            </figure>
                            {{-- Badge Pillar of cummunity --}}
                            @if ($user->badges()->where('type', 'topLeaderboard')->exists())
                                    <?php $badge = $user->badges()->where('type', 'topLeaderboard')->first(); ?>
                                <span class="absolute top-1 left-1">
                                <x-badge.icon.pillarofcommunity />
                            </span>
                            @endif
                        </div>
                        {{-- User username --}}
                        <div class="font-bold text-xl">
                            {{ $user->username }}
                        </div>
                    </div>

                    <div class="w-full md:w-1/2">
                        <div class="pb-2 mx-5 border-dotted border-b border-slate-500">
                            @foreach ($user->roles as $role)
                                <span class="font-bold" style="color:{{ $role->color }}">{{ $role->name }}</span>
                            @endforeach
                        </div>

                        <div class="py-2 mx-5 border-dotted border-b border-slate-500">
                            Joined<br>
                            {{ $user->created_at->format('d-m-Y') }}
                        </div>

                        <ul class="pt-2 flex flex-row gap-2 justify-center w-full">
                            @if ($user->facebook)
                                <li>
                                    <a class="tooltip" href="{{ url('https://facebook.com/' . e($user->facebook)) }}"
                                       data-tip="https://facebook.com/{{ e($user->facebook) }}" title="Facebook">
                                        <x-icon name="fab-square-facebook" class="h-6 w-6"></x-icon>
                                    </a>
                                </li>
                            @endif
                            @if ($user->twitter)
                                <li>
                                    <a class="tooltip" href="{{ url('https://twitter.com/' . e($user->twitter)) }}"
                                       data-tip="https://twitter.com/{{ e($user->twitter) }}" title="Twitter">
                                        <x-icon name="fab-square-twitter" class="h-6 w-6"></x-icon>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8">
                <div class="grid grid-cols-12 gap-4 text-center h-full mx-3 lg:mx-0">
                    <div class="col-span-12 lg:col-span-4 h-full">
                        <div
                            class="flex flex-col items-center justify-between shadow-md bg-white dark:bg-base-300 rounded-lg p-6 h-full tooltip"
                            data-tip="{{ $level['experienceNeededNextLevel'] }} experiences to go before next level.">
                            <x-icon name="fas-star" class="h-26 w-26 text-[color:var(--color-warning)]"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $user->experiences_total }}
                                </div>
                                <p>
                                    Total Experiences
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4 h-full">
                        <div
                            class="flex flex-col items-center justify-between shadow-md bg-white dark:bg-base-300 rounded-lg p-6 h-full">
                            <x-icon name="far-gem" class="h-26 w-26 text-primary"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $user->rubies_total }}
                                </div>
                                <p>
                                    Total Rubies
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4 h-full">
                        <div
                            class="flex flex-col items-center justify-between shadow-md bg-white dark:bg-base-300 rounded-lg p-6 h-full">
                            <x-icon name="far-comments" class="h-26 w-26 text-[color:#5ccc5c]"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $user->discuss_post_count }}
                                </div>
                                <p>
                                    Total Discuss Messages
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- Biography --}}
    <section class="lg:container mx-auto py-6">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                <h2 class="text-2xl text-center font-bold uppercase mb-5">
                    Biography
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div class="col-span-1 mx-3 lg:mx-0">
                <div
                    class="flex flex-row gap-3 items-center overflow-hidden shadow-md bg-white dark:bg-base-300 rounded-lg py-9 px-5">
                    <div>
                        <x-icon name="fas-quote-left" class="text-primary h-7 w-7" />
                    </div>
                    <div class="prose min-w-full">
                        @empty($user->biography)
                            @if (Auth::user() && $user->id == Auth::id())
                                You don't have set a biography.
                                <x-button link="{{ route('user.account.index') }}" icon="fas-plus" label="Add now" class="btn-outline-primary btn-sm gap-2" />
                            @else
                                This user hasn't set a biography yet.
                            @endif
                        @else
                            {!! Markdown::convert($user->biography) !!}
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Badges --}}
    <section class="lg:container mx-auto py-6">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                <h2 class="text-2xl text-center font-bold uppercase mb-5">
                    Badges
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="col-span-12 mx-3 lg:mx-0">
                <div
                    class="shadow-md bg-white dark:bg-base-300 rounded-lg py-9 px-5">
                    <ul class="flex flex-row flex-wrap items-center justify-center gap-3">
                        @foreach ($badges as $badge)
                            @if ($badge->type !== 'topLeaderboard')
                                <li class="flex items-center justify-center w-11 h-11 rounded-full p-1 border-2 border-solid {{ $user->badges->contains($badge->id) ? 'border-[color:rgba(221,221,211,0.5) dark:border-[color:#ffffff]' : 'border-[color:rgba(221,221,211,0.5)]' }} cursor-pointer">
                                    <div class="dropdown dropdown-hover dropdown-top dropdown-center">
                                        <label tabindex="0" class="m-1">
                                            <x-icon
                                                class="h-7 w-7"
                                                name="{{ $badge->icon }}"
                                                style="color:{{ $user->badges->contains($badge->id) ? $badge->color : 'rgba(221,221,211,0.5)' }};"></x-icon>
                                        </label>
                                        <div tabindex="0"
                                             class="dropdown-content card card-compact bg-base-100 w-96 p-2 shadow">
                                            <div class="card-body">
                                                <h3 class="card-title">
                                                    {{ $badge->name }}
                                                </h3>
                                                <p>
                                                    {{ $badge->description }}
                                                </p>
                                                @if($user->badges->contains($badge->id))
                                                    <div class="divider"></div>
                                                    <p class="text-sm">
                                                        You have unlocked this badge the {{ $userBadges[$badge->id]->pivot->created_at->format('Y-m-d H:i:s') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Level --}}
    <section class="lg:container mx-auto py-6">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                <h2 class="text-2xl text-center font-bold uppercase mb-5">
                    Level
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1">
            <div class="col-span-12 mx-3 lg:mx-0">
                <div class="flex justify-between">
                    <div class="font-bold tooltip" data-tip="{{ $level['currentLevelExperience'] }} XP needed for Level {{ $level['currentLevel'] }}">
                        LEVEL {{ $level['currentLevel'] }}
                    </div>
                    <div class="font-bold">
                        @if($level['maxLevel'] !== true)
                            <span class="tooltip" data-tip="{{ $level['nextLevelExperience'] }} XP needed for Level {{ $level['nextLevel'] }}">
                            LEVEL {{ $level['nextLevel'] }}
                        </span>
                        @else
                            <span class="tooltip" data-tip="You have reached the max level, what a machine !">
                            MAX LEVEL
                        </span>
                        @endif
                    </div>
                </div>
                <progress class="progress progress-primary h-4"  value="{{ $level['currentProgression'] }}" max="100"></progress>

            </div>
        </div>
    </section>

    {{-- Activity --}}
    <section class="lg:container mx-auto py-6 mb-9">
        <div class="grid grid-cols-1">
            <div class="col-span-12">
                <h2 class="text-2xl text-center font-bold uppercase mb-5">
                    Activity
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-12">
            <div class="col-span-12 lg:col-span-9 lg:col-start-3 mx-3 lg:mx-0">
                @forelse($activities as $activity)
                    <div class="flex py-8">
                        <div class="pt-1.5 hidden sm:block">
                            <time class="block w-[150px] tooltip text-end"
                                  datetime="{{ $activity->created_at->format('Y-m-d H:i:s') }}"
                                  data-tip="{{ $activity->created_at->format('Y-m-d H:i:s') }}">
                                {{ $activity->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <div class="py-1 px-2.5 z-10">
                            @if(get_class($activity) == \Xetaravel\Models\BlogArticle::class)
                                <x-icon name="far-newspaper" class="h-8 w-8 text-current bg-[color:var(--color-base-100)] border-2 border-current rounded-full p-0.5" />
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                <x-icon name="fas-pager" class="h-8 w-8 text-current bg-[color:var(--color-base-100)] border-2 border-current rounded-full p-0.5" />
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                <x-icon name="far-comments" class="h-8 w-8 text-current bg-[color:var(--color-base-100)] border-2 border-current rounded-full p-0.5" />
                            @elseif(get_class($activity) == \Xetaravel\Models\BlogComment::class)
                                <x-icon name="far-message" class="h-8 w-8 text-current bg-[color:var(--color-base-100)] border-2 border-current rounded-full p-0.5" />
                            @endif
                        </div>
                        <div
                            class="relative before:border-current before:border-l-2 before:-bottom-[68px] before:-left-7 before:absolute before:top-2.5">
                            <h3 class="text-2xl font-bold line-clamp-1">
                                @if(get_class($activity) == \Xetaravel\Models\BlogArticle::class)
                                    Created article <a class="link link-hover link-primary"
                                                       href="{{ $activity->show_url }}">{{ Str::limit($activity->title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                    Created conversation <a class="link link-hover link-primary"
                                                            href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                    Replied to <a class="link link-hover link-primary"
                                                  href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\BlogComment::class)
                                    Replied to article <a class="link link-hover link-primary"
                                                          href="{{ $activity->article->show_url }}">{{ Str::limit($activity->article->title, 150) }}</a>
                                @endif
                            </h3>
                            <div class="prose min-w-full">
                                @if(get_class($activity) == \Xetaravel\Models\BlogArticle::class)
                                    {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                    {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                    {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                                @elseif(get_class($activity) == \Xetaravel\Models\BlogComment::class)
                                    {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mb-1 text-center">
                        This user does not have any activities.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
