@extends('layouts.app')
{!! config(['app.title' => $user->username . ' profile']) !!}

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="background-container">
            {!! Html::image($user->profile_background, 'Profile background', ['class' => 'background']) !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="profile-information text-xs-center">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            {!! Html::image($user->avatar_small, $user->username, ['class' => 'rounded-circle']) !!}
                            <h2 class="username font-xeta">
                                {{ $user->username }}
                            </h2>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-header-navbar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="statistics list-inline pull-left">
                        <li class="list-inline-item">
                            <span class="text">Comments</span>
                            <span class="number">
                                {{ $user->comment_count }}
                            </span>
                        </li>
                        <li class="list-inline-item">
                            <span class="text">Articles</span>
                            <span class="number">
                                {{ $user->article_count }}
                            </span>
                        </li>
                    </ul>

                    <ul class="socials list-inline pull-right">
                        @if ($user->facebook)
                            <li class="list-inline-item">
                                {!! Html::link(
                                    url('http://facebook.com/' . e($user->facebook)),
                                    '<i class="fa fa-facebook fa-2x"></i>',
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
                                    '<i class="fa fa-twitter fa-2x"></i>',
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
                        @if (Auth::user() && $user->id == Auth::user()->id)
                            <li class="list-inline-item" style="padding: 10px;">
                                {!! Html::link(route('users.account.index'), 'Edit my profile', ['class' => 'btn btn-outline-primary']) !!}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pt-1">
    <div class="row">
        <div class="col-md-12">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
    <div class="row profile">
        <div class="col-lg-3">
            <section class="sidebar-profile section">
                <div class="avatar">
                    {!! Html::image($user->avatar_small, 'Avatar', ['width' => '120', 'height' => '120']) !!}
                </div>
                <h4 class="mt-1 font-xeta">
                    {{ $user->username }}
                </h4>

                <div class="role">
                    @foreach ($user->roles as $role)
                        <span style="{{ $role->css }}">{{ $role->name }}</span>
                    @endforeach
                </div>

                <span class="joinedDate">
                    Joined<br>
                    {{ $user->created_at->format('d-m-Y') }}
                </span>

                <ul class="social">
                    @if ($user->facebook)
                        <li class="list-inline-item">
                            {!! Html::link(
                                url('http://facebook.com/' . e($user->facebook)),
                                '<i class="fa fa-facebook fa-2x"></i>',
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
                                '<i class="fa fa-twitter fa-2x"></i>',
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
            </section>
        </div>

        <div class="col-lg-9">
            <section class="section">
                <div class="hr-divider">
                    <h4 class="font-xeta text-xs-center">
                        @if (Auth::user() && $user->id == Auth::user()->id)
                            Your Biography
                        @else
                            His Biography
                        @endif
                    </h4>
                </div>
                <div class="biography pt-1 pb-2">
                    @if (!empty($user->biography))
                        {!! Purifier::clean($user->biography, 'user_biography') !!}
                    @else
                        @if (Auth::user() && $user->id == Auth::user()->id)
                            You don't have set a biography.
                            {!! Html::link(route('users.account.index'), '<i class="fa fa-plus"></i> Add one now', ['class' => 'btn btn-outline-primary'], null, false) !!}
                        @else
                            This user hasn't set a biography yet.
                        @endif
                    @endif
                </div>

                <div class="hr-divider">
                    <h4 class="font-xeta text-xs-center">
                        @if (Auth::user() && $user->id == Auth::user()->id)
                            Your Badges
                        @else
                            His Badges
                        @endif
                    </h4>
                </div>
                <div class="badges pt-1 pb-2">
                    @if ($user->badges->isNotEmpty())
                        @foreach ($user->badges as $badge)
                        <div class="d-inline-block text-xs-center pr-1">
                            <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" width="105" data-toggle="tooltip" title="{{ $badge->name }}">
                        </div>
                        @endforeach
                    @else
                        @if (Auth::user() && $user->id == Auth::user()->id)
                            You don't have unlocked a badge yet.
                        @else
                            This user hasn't set unloacked a badge yet.
                        @endif
                    @endif
                </div>

                @if (!empty($user->articles->toArray()))
                    <div class="hr-divider">
                        <h4 class="font-xeta text-xs-center">
                            @if (Auth::user() && $user->id == Auth::user()->id)
                                Your lastest Articles in the Blog
                            @else
                                His lastest Articles in the Blog
                            @endif
                        </h4>
                    </div>
                    <table class="table table-profile">
                        @foreach ($user->articles as $article)
                            <tr>
                                <td>
                                    {!! Html::image($user->avatar_small, 'Avatar', ['class' => 'img-thumbnail avatar']) !!}
                                    {!! Html::link(route('blog.article.show', ['slug' => $article->slug, 'id' => $article->id]), $article->title, ['class' => 'title text-primary']) !!}
                                    <div>
                                        {!! Purifier::clean(
                                            str_limit($article->content, 275),
                                            'blog_article_empty'
                                        ) !!}
                                    </div>
                                    <time>
                                        Created at {{ $article->created_at->format('H:i:s Y-m-d') }}
                                    </time>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                @if (!empty($user->comments->toArray()))
                    <div class="hr-divider">
                        <h4 class="font-xeta text-xs-center">
                            @if (Auth::user() && $user->id == Auth::user()->id)
                                Your lastest Comments in the Blog
                            @else
                                His lastest Comments in the Blog
                            @endif
                        </h4>
                    </div>
                    <table class="table table-profile">
                        @foreach ($user->comments as $comment)
                            <tr>
                                <td>
                                    {!! Html::image($user->avatar_small, 'Avatar', ['class' => 'img-thumbnail avatar']) !!}
                                    {!! Html::link(route('blog.article.show', ['slug' => $comment->article->slug, 'id' => $comment->article->id]), $comment->article->title, ['class' => 'title text-primary']) !!}
                                    <div>
                                        {!! Purifier::clean(
                                            str_limit($comment->content, 275),
                                            'blog_article_empty'
                                        ) !!}
                                    </div>
                                    <time>
                                        Created at {{ $comment->created_at->format('H:i:s Y-m-d') }}
                                    </time>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </section>
        </div>
    </div>
</div>

@endsection
