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

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12">
            <h1 class="text-2xl text-center font-bold font-xetaravel uppercase mb-5">
                {{ e($user->username) }}  profile
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 lg:col-span-4 mx-3 lg:mx-0">
            <div class="flex flex-col sm:flex-row bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 w-full h-full">
                <div class="w-1/2 text-center">
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
                <div class="w-1/2">
                    <div class="profile-sidebar-role">
                        @foreach ($user->roles as $role)
                            <span style="{{ $role->css }}">{{ $role->name }}</span>
                        @endforeach
                    </div>

                    <span class="profile-sidebar-joinedDate">
                        Joined<br>
                        {{ $user->created_at->format('d-m-Y') }}
                    </span>

                    <ul class="profile-sidebar-social">
                        @if ($user->facebook)
                            <li class="list-inline-item">
                                {!! Html::link(
                                    url('http://facebook.com/' . e($user->facebook)),
                                    '<i class="fa fa-facebook"></i>',
                                    [
                                        'class' => 'text-primary',
                                        'target' => '_blank',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => 'http://facebook.com/' . e($user->facebook)
                                    ],
                                    null,
                                    false
                                ) !!}
                            </li>
                        @endif
                        @if ($user->twitter)
                            <li class="list-inline-item">
                                {!! Html::link(
                                    url('http://twitter.com/' . e($user->twitter)),
                                    '<i class="fa fa-twitter"></i>',
                                    [
                                        'class' => 'text-primary',
                                        'target' => '_blank',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => 'http://twitter.com/' . e($user->twitter)
                                    ],
                                    null,
                                    false
                                ) !!}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-8">
            <div class="grid grid-cols-12 gap-4 text-center h-full mx-3 lg:mx-0">
                <div class="col-span-12 lg:col-span-4 h-full">
                    <div class="flex flex-col justify-between  bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full tooltip" data-tip="{{ $level['experienceNeededNextLevel'] }} experiences to go before next level.">
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
                    <div class="flex flex-col justify-between bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full">
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
                    <div class="flex flex-col justify-between bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 h-full">
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

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="row">
        <div class="col-lg-12 mt-2 mb-2">
            <div class="title-section text-xs-center font-weight-bold font-xeta text-uppercase">
                Biography
            </div>
        </div>
        <div class="col-lg-12">
            <div class="biography-section d-flex">
                <div class="biography-icon">
                    <i class="fas fa-quote-left fa-2x text-primary"></i>
                </div>
                <div class="biography-content">
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

<!--<section class="lg:container mx-auto pt-4 mb-5">
    <div class="row">
        <div class="col-lg-12 mt-2 mb-2">
            <div class="title-section text-xs-center font-weight-bold font-xeta text-uppercase">
                Badges
            </div>
        </div>

        <div class="col-lg-12">
            <div class="badges">
                <ul class="list-inline">
                    @foreach ($badges as $badge)
                        @if ($badge->slug !== 'topleaderboard')
                            <li class="list-inline-item">
                                <i aria-hidden="true" data-toggle="popover" class="profile-badges-item {{ $badge->icon }}" title="{{ $badge->name }}" data-content="{{ $badge->description }}" data-placement="top" data-trigger="hover" style="color:{{ $user->badges->contains($badge->id) ? $badge->color : '#ddd' }}; {{ $badge->slug == "topleaderboard" ? "border-color: #eefc24;color:#fff;background-color:" . $badge->color : "" }}"></i>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-lg-12 mt-2 mb-2">
            <div class="title-section text-xs-center font-weight-bold font-xeta text-uppercase">
                Level
            </div>
        </div>

        <div class="col-lg-12">
            <div class="d-flex justify-content-between">
                <div class="font-weight-bold" data-toggle="tooltip" data-placement="top" title="{{ $level['currentLevelExperience'] }} XP needed for Level {{ $level['currentLevel'] }}">
                    LEVEL {{ $level['currentLevel'] }}
                </div>
                <div class="font-weight-bold">
                    @if($level['maxLevel'] != true)
                        <span data-toggle="tooltip" data-placement="top" title="{{ $level['nextLevelExperience'] }} XP needed for Level {{ $level['nextLevel'] }}">
                            LEVEL {{ $level['nextLevel'] }}
                        </span>
                    @else
                        <span data-toggle="tooltip" data-placement="top" title="You have reached the max level, what a machine !">
                            MAX LEVEL
                        </span>
                    @endif
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar font-weight-bold" role="progressbar" style="width: {{ $level['currentProgression'] }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $level['currentUserExperience'] }} XP</div>
            </div>
        </div>
    </div>
</section>-->

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="row">
        @if (Auth::user() && $user->id == Auth::id())
            <div class="col-lg-12 text-xs-right">
                {!! Html::link(route('users.account.index'), 'Edit my profile', ['class' => 'btn btn-outline-primary']) !!}
            </div>
        @endif
        <div class="col-lg-12">
            <div class="title-section text-xs-center font-weight-bold font-xeta text-uppercase">
                Activity
            </div>
        </div>
        <div class="col-lg-10 offset-lg-1">
            @if($activities->isEmpty())
                <div class="mb-1 text-xs-center">
                    This user does not have any activities.
                </div>
            @else
                @foreach($activities as $activity)
                    <div class="activities-section">
                        <div class="activities-date">
                            <time datetime="{{ $activity->created_at->format('Y-m-d H:i:s') }}" title="{{ $activity->created_at->format('Y-m-d H:i:s') }}" data-toggle="tooltip">
                                {{ $activity->created_at->diffForHumans() }}
                            </time>
                        </div>
                        <div class="activities-icon">
                            @if(get_class($activity) == \Xetaravel\Models\Article::class)
                                <i class="fa fa-newspaper-o"></i>
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                <i class="fas fa-newspaper"></i>
                            @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                <i class="far fa-comments"></i>
                            @elseif(get_class($activity) == \Xetaravel\Models\Comment::class)
                                <i class="far fa-comment-alt"></i>
                            @endif
                        </div>
                        <div class="activities-content">
                            <p class="activities-content-title">
                                @if(get_class($activity) == \Xetaravel\Models\Article::class)
                                    Created article <a href="{{ $activity->article_url }}">{{ Str::limit($activity->title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class && $activity->id === $activity->conversation_first_post_id)
                                    Created conversation <a href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\DiscussPost::class)
                                    Replied to <a href="{{ route('discuss.conversation.show', ['slug' => $activity->conversation_slug, 'id' => $activity->conversation_id]) }}">{{ Str::limit($activity->conversation_title, 150) }}</a>
                                @elseif(get_class($activity) == \Xetaravel\Models\Comment::class)
                                    Replied to article <a href="{{ $activity->article->article_url }}">{{ Str::limit($activity->article->title, 150) }}</a>
                                @endif
                            </p>
                            <div class="activities-content-text">
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
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
