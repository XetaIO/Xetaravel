@extends('layouts.app')
{!! config(['app.name' => $user->username . ' profile']) !!}

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
                            {!! Html::image($user->avatar, $user->username, ['class' => 'rounded-circle']) !!}
                            <h2 class="username">
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
                        @if (!$user->facebook)
                            <li class="list-inline-item">
                                {!! Html::link(url('http://facebook.com/' . 'ZoRo'), '<i class="fa fa-facebook fa-2x"></i>', ['class' => 'text-primary', 'target' => '_blank', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'http://facebook.com/' . 'ZoRo'], null, false) !!}

                            </li>
                        @endif
                        @if (!$user->twitter)
                            <li class="list-inline-item">
                                {!! Html::link(url('http://twitter.com/' . 'ZoRo'), '<i class="fa fa-twitter fa-2x"></i>', ['class' => 'text-primary', 'target' => '_blank', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'http://twitter.com/' . 'ZoRo'], null, false) !!}
                            </li>
                        @endif
                        @if ($user->id == Auth::user()->id)
                            <li class="list-inline-item" style="padding: 10px;">
                                {!! Html::link(route('users_user_index'), 'Edit my profile', ['class' => 'btn btn-outline-primary']) !!}
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
            <nav class="breadcrumb">
                {!! Html::link(route('page_index'), 'Home', ['class' => 'breadcrumb-item']) !!}
                {!! Html::link(route('page_index'), 'Users', ['class' => 'breadcrumb-item']) !!}
                <span class="breadcrumb-item active">{{ $user->username }}</span>
            </nav>
        </div>
    </div>
    <div class="row profile">
        <div class="col-lg-3">
            <section class="sidebar-profile section">
                <div class="avatar">
                    {!! Html::image($user->avatar, 'Avatar', ['width' => '120', 'height' => '120']) !!}
                </div>
                <h4 class="mt-1">
                    {{ $user->username }}
                </h4>

                <span class="group {{ Auth::user()->isAdmin() ? 'admin' : '' }}">
                    @if (Auth::user()->isAdmin())
                        Administrator
                    @else
                        Member
                    @endif
                </span>

                <span class="joinedDate">
                    Joined<br>
                    {{ $user->created_at->format('Y-m-d') }}
                </span>

                <ul class="social">
                    @if (!$user->facebook)
                        <li class="list-inline-item">
                            {!! Html::link(url('http://facebook.com/' . 'ZoRo'), '<i class="fa fa-facebook fa-2x"></i>', ['target' => '_blank'], null, false) !!}
                        </li>
                    @endif
                    @if (!$user->twitter)
                        <li class="list-inline-item">
                            {!! Html::link(url('http://twitter.com/' . 'ZoRo'), '<i class="fa fa-twitter fa-2x"></i>', ['target' => '_blank'], null, false) !!}
                        </li>
                    @endif
                </ul>
            </section>
        </div>

        <div class="col-lg-9">
            <section class="section">

                @if (!empty($user->articles->toArray()))
                    <div class="hr-divider">
                        <h4 class="text-xs-center">
                            @if ($user->id == Auth::user()->id)
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
                                    {!! Html::image($user->avatar, 'Avatar', ['class' => 'img-thumbnail avatar']) !!}
                                    {!! Html::link(route('blog_article_show', ['slug' => $article->slug, 'id' => $article->id]), $article->title, ['class' => 'title text-primary']) !!}
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
                        <h4 class="text-xs-center">
                            @if ($user->id == Auth::user()->id)
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
                                    {!! Html::image($user->avatar, 'Avatar', ['class' => 'img-thumbnail avatar']) !!}
                                    {!! Html::link(route('blog_article_show', ['slug' => $comment->article->slug, 'id' => $comment->article->id]), $comment->article->title, ['class' => 'title text-primary']) !!}
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
