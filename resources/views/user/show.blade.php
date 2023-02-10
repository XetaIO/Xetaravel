@extends('layouts.app')
{!! config(['app.title' => e($user->username) . ' profile']) !!}

@push('meta')
  <x-meta title="{{ e($user->username) }}  profile" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

{{-- User Profile --}}
<section class="lg:container mx-auto py-6">
    <div class="grid grid-cols-1">
        <div class="col-span-12">
            <h1 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
                {{ e($user->username) }}  profile
            </h1>
        </div>
        <div class="col-span-12 mb-3 mx-3">
            @if (Auth::user() && $user->id == Auth::id())
                <div class="text-right">
                    <a class="btn btn-primary gap-2" href="{{ route('users.account.index') }}">
                        <i class="fa-solid fa-pencil"></i>
                        Edit my profile
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 lg:col-span-4 mx-3 lg:mx-0">
            <div class="flex flex-col sm:flex-row text-center shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 w-full h-full">

                <div class="w-full md:w-1/2">
                    {{--  User Avatar --}}
                    <div class="relative avatar {{ $user->online ? 'online' : 'offline' }} m-2">
                        <figure class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $user->username }} is {{ $user->online ? 'online' : 'offline' }}">
                            <img class="rounded-full" src="{{ $user->avatar_small }}"  alt="{{ $user->full_name }} avatar" />
                        </figure>
                        {{-- Badge Pillar of cummunity --}}
                        @if ($user->badges()->where('slug', 'topleaderboard')->exists())
                            <?php $badge = $user->badges()->where('slug', 'topleaderboard')->first(); ?>
                            <span class="absolute top-1 left-1">
                                <x-badge.icon.pillarofcommunity />
                            </span>
                        @endif
                    </div>
                    {{-- User username --}}
                    <div class="font-xetaravel font-bold text-xl">
                        {{ $user->username }}
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="pb-2 mx-5 border-dotted border-b border-slate-500">
                        @foreach ($user->roles as $role)
                            <span style="{{ $role->css }}">{{ $role->name }}</span>
                        @endforeach
                    </div>

                    <div class="py-2 mx-5 border-dotted border-b border-slate-500">
                        Joined<br>
                        {{ $user->created_at->format('d-m-Y') }}
                    </div>

                    <ul class="pt-2 flex flex-row gap-2 justify-center w-full">
                        @if ($user->facebook)
                            <li class="">
                                <a class="tooltip" href="{{ url('http://facebook.com/' . e($user->facebook)) }}" datat-tip="http://facebook.com/{{ e($user->facebook) }}" title="Facebook">
                                    <i class="fa-brands fa-square-facebook fa-2xl"></i>
                                </a>
                            </li>
                        @endif
                        @if ($user->twitter)
                            <li class="">
                                <a class="tooltip" href="{{ url('http://twitter.com/' . e($user->twitter)) }}" datat-tip="http://twitter.com/{{ e($user->twitter) }}" title="Twitter">
                                    <i class="fa-brands fa-square-twitter fa-2xl"></i>
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
                    <div class="flex flex-col justify-between shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full tooltip" data-tip="{{ $level['experienceNeededNextLevel'] }} experiences to go before next level.">
                        <i class="fa-solid fa-star text-[color:hsl(var(--wa))] text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl font-xetaravel">
                                {{ $user->experiences_total }}
                            </div>
                            <p class="text-muted">
                                Total Experiences
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4 h-full">
                    <div class="flex flex-col justify-between shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full">
                        <i class="fa-regular fa-gem text-primary text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl font-xetaravel">
                                {{ $user->rubies_total }}
                            </div>
                            <p class="text-muted">
                                Total Rubies
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4 h-full">
                    <div class="flex flex-col justify-between shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full">
                        <i class="fa-regular fa-comments text-[color:#5ccc5c] text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl font-xetaravel">
                                {{ $user->discuss_post_count }}
                            </div>
                            <p class="text-muted">
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
            <h2 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
                Biography
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-1 mx-3 lg:mx-0">
            <div class="flex flex-row gap-3 items-center overflow-hidden shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg py-9 px-5">
                <div class="">
                    <i class="fa-solid fa-quote-left text-primary text-5xl"></i>
                </div>
                <div class="prose min-w-full">
                    @empty($user->biography)
                        @if (Auth::user() && $user->id == Auth::id())
                            You don't have set a biography.
                            {!! Html::link(route('users.account.index'), '<i class="fa fa-plus"></i> Add now', ['class' => 'btn btn-outline-primary'], null, false) !!}
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
            <h2 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
                Badges
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            <div class="shadow-md bg-white dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg py-9 px-5">
                <ul class="flex flex-row flex-wrap items-center justify-center gap-3">
                    @foreach ($badges as $badge)
                        @if ($badge->slug !== 'topleaderboard')
                            <li class="flex items-center w-11 h-11 rounded-full p-1 border-2 border-solid {{ $user->badges->contains($badge->id) ? 'border-[color:rgba(221,221,211,0.5) dark:border-[color:#ffffff]' : 'border-[color:rgba(221,221,211,0.5)]' }} hover:cursor-pointer">
                                <div class="dropdown dropdown-hover dropdown-top hover:cursor-pointer">
                                    <label tabindex="0" class="m-1">
                                        <i class="fa-xl {{ $badge->icon }}" style="color:{{ $user->badges->contains($badge->id) ? $badge->color : 'rgba(221,221,211,0.5)' }}; {{ $badge->slug == "topleaderboard" ? "border-color: #eefc24;color:#fff;background-color:" . $badge->color : "" }}"></i>
                                    </label>
                                    <div tabindex="0" class="dropdown-content card card-compact bg-base-100 w-96 p-2 shadow">
                                        <div class="card-body">
                                            <h3 class="card-title">
                                                {{ $badge->name }}
                                            </h3>
                                            <p>
                                                {{ $badge->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
</section>

{{-- Level --}}
<section class="lg:container mx-auto py-6">
    <div class="grid grid-cols-1">
        <div class="col-span-12">
            <h2 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
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
                    @if($level['maxLevel'] != true)
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
            <progress class="progress progress-primary h-4" value="{{ $level['currentProgression'] }}" max="100"></progress>
        </div>
    </div>
</section>

{{-- Activity --}}
<section class="lg:container mx-auto py-6 mb-9">
    <div class="grid grid-cols-1">
        <div class="col-span-12">
            <h2 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
                Activity
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12 lg:col-span-9 lg:col-start-3 mx-3 lg:mx-0">
            @forelse($activities as $activity)
                <div class="flex py-8">
                    <div class="pt-1.5 hidden sm:block">
                        <time class="block w-[150px] tooltip text-end" datetime="{{ $activity->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $activity->created_at->format('Y-m-d H:i:s') }}">
                            {{ $activity->created_at->diffForHumans() }}
                        </time>
                    </div>

                    <div class="py-1 px-2.5 z-10">
                        @if(get_class($activity) == \Xetaravel\Models\Article::class)
                            <i class="fa-solid fa-newspaper bg-[color:hsla(var(--b1))] text-current border-2 border-current rounded-full p-1.5"></i>
                        @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                            <i class="fa-solid fa-pager bg-[color:hsla(var(--b1))] text-current border-2 border-current rounded-full p-1.5"></i>
                        @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                            <i class="fa-regular fa-comments bg-[color:hsla(var(--b1))] text-current border-2 border-current rounded-full p-1 pt-1.5 h-8 w-8"></i>
                        @elseif(get_class($activity) == \Xetaravel\Models\Comment::class)
                            <i class="fa-regular fa-message bg-[color:hsla(var(--b1))] text-current border-2 border-current rounded-full p-1.5"></i>
                        @endif
                    </div>
                    <div class="relative before:border-current before:border-l-2 before:-bottom-[68px] before:-left-7 before:absolute before:top-2.5">
                        <h3 class="text-2xl font-bold line-clamp-1">
                            @if(get_class($activity) == \Xetaravel\Models\Article::class)
                                Created article <a class="link link-hover link-primary" href="{{ $activity->article_url }}">{{ Str::limit($activity->title, 150) }}</a>
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                Created conversation <a class="link link-hover link-primary" href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                Replied to <a class="link link-hover link-primary" href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                            @elseif(get_class($activity) == \Xetaravel\Models\Comment::class)
                                Replied to article <a class="link link-hover link-primary" href="{{ $activity->article->article_url }}">{{ Str::limit($activity->article->title, 150) }}</a>
                            @endif
                        </h3>
                        <div class="prose min-w-full">
                            @if(get_class($activity) == \Xetaravel\Models\Article::class)
                                {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                {!! Markdown::convert(Str::limit($activity->content, 650)) !!}
                            @elseif(get_class($activity) == \Xetaravel\Models\Comment::class)
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
@endsection
