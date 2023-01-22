@extends('layouts.app')
{!! config(['app.title' => e($user->username) . ' profile']) !!}

@push('meta')
  <x-meta title="{{ e($user->username) }}  profile" />
@endpush

@section('content')
<div class="container pt-6">
    <div class="row">
        <div class="col-md-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
    <div class="col-lg-12 mt-2 mb-2">
        <div class="title-section text-xs-center font-weight-bold font-xeta text-uppercase">
            Profile
        </div>
    </div>
    <div class="row profile">
        <div class="col-lg-4">
            <div class="profile-sidebar">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="profile-sidebar-avatar">
                            @if ($user->badges()->where('slug', 'topleaderboard')->exists())
                                    <?php $badge = $user->badges()->where('slug', 'topleaderboard')->first(); ?>
                                <i aria-hidden="true"
                                   data-toggle="popover"
                                   class="profile-badges-item {{ $badge->icon }}"
                                   title="{{ $badge->name }}"
                                   data-content="{{ $badge->description }}"
                                   data-placement="bottom"
                                   data-trigger="hover"
                                   style="border-color: #eefc24;background-color: {{ $badge->color }} ">
                                </i>
                            @endif
                            {!! Html::image($user->avatar_small, 'Avatar', ['width' => '120', 'height' => '120']) !!}
                        </div>
                        <div class="mt-1 font-xeta profile-sidebar-username">
                            {{ $user->username }}
                        </div>
                    </div>
                    <div class="col-lg-6">
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
        </div>
        <div class="col-lg-8">
            <div class="row" style="height: 100%">
                <div class="col-lg-4 ">
                    <div class="profile-box" data-toggle="popover" title="" data-html="true" data-content="<b>{{ $level['experienceNeededNextLevel'] }}</b> <i>experiences to go before next level.</i>" data-trigger="hover" data-placement="bottom">
                        <i aria-hidden="true" class="fa fa-star profile-box-icon-experiences fa-5x" style="color: #f39c12;"></i>
                        <div class="features-box-title">
                            {{ $user->experiences_total }}
                        </div>
                        <p class="text-muted">
                            Total Experiences
                        </p>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="profile-box">
                        <i aria-hidden="true" class="fa fa-diamond text-primary profile-box-icon fa-5x"></i>
                        <div class="features-box-title">
                            {{ $user->rubies_total }}
                        </div>
                        <p class="text-muted">
                            Total Rubies
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="profile-box">
                        <i aria-hidden="true" class="fa fa-comment-o profile-box-icon-comment fa-5x"></i>
                        <div class="profile-box-title">
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
<div class="container pt-4">
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
</div>
<div class="container pt-4 pb-4">
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
</div>
<div class="container pt-2 pb-4">
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
            @empty($activities)
                This user does not have any activities.
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
            @endempty
        </div>
    </div>
</div>
@endsection
