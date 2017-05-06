@extends('layouts.app')
{!! config(['app.title' => $article->title]) !!}

@push('scripts')
    @if (Auth::user())
        {!! Html::script('/vendor/ckeditor/release/ckeditor.js')!!}
    @endif
    
    {!! Html::script('js/highlight.min.js')!!}
    <script type="text/javascript">
        @if (Auth::user())
            /**
            * CKEditor
            */
            CKEDITOR.plugins.addExternal('pbckcode', 'http://prbaron.github.com/pbckcode/plugins/pbckcode/', 'plugin.js');
            CKEDITOR.replace('commentBox', {
                customConfig: '../config/comment.js'
            });
        @endif
        
        /**
         * HighlightJS.
         */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="container pb-1">
    <div class="blog-header mt-2">
        <div class="container">
            <h1 class="blog-title">
                {{ $article->title }}
            </h1>
        </div>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">

        <div class="col-md-9">
            <div class="blog-post">
                <div class="blog-post-meta">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-calendar" aria-hidden="true"></i> {{ $article->created_at }}
                        </li>
                    </ul>
                </div>
                {!! Purifier::clean($article->content, 'blog_article') !!}
            </div>

            <hr />
            <div class="card card-outline-primary">
                <div class="card-block" style="display: flex;">
                    <div class="card-left" style="padding-right: 15px;">
                        <a href="{{ route('users_user_show', ['slug' => $article->user->slug, 'id' => $article->user->id]) }}">
                            <img class="card-media rounded-circle" src="{{ asset($article->user->avatar_small) }}" alt="Avatar" height="64px", width="64px">
                        </a>
                    </div>
                    <div class="card-body" style="flex: 1;">
                        <h4 class="card-title text-truncate">
                            <a href="{{ route('users_user_show', ['slug' => $article->user->slug, 'id' => $article->user->id]) }}">
                                {{ $article->user->username }}
                            </a>
                        </h4>

                        <p class="card-subtitle text-muted">
                            {!! Purifier::clean($article->user->signature, 'user_signature') !!}
                        </p>
                    </div>
                </div>
            </div>

            @if (!empty($comments->toArray()['data']))
                <h4 class="mt-3 font-xeta">
                    {{ $article->comment_count }} Comments
                </h4>
                @foreach ($comments as $comment)
                    <div class="media">
                        <div class="media-left">
                        <a href="{{ route('users_user_show', ['slug' => $comment->user->slug, 'id' => $comment->user->id]) }}">
                            <img class="media-object rounded-circle" src="{{ asset($article->user->avatar_small) }}" alt="Avatar" height="64px", width="64px">
                        </a>
                        </div>

                        <div class="media-body">
                            <h5 class="media-heading">
                                <a href="{{ route('users_user_show', ['slug' => $comment->user->slug, 'id' => $comment->user->id]) }}">
                                    {{ $comment->user->username }}
                                </a>
                            </h5>

                            <small class="text-muted">
                                <i class="fa fa-calendar" aria-hidden="true"  data-toggle="tooltip" title="Date"></i>
                                {{ $comment->created_at }}
                            </small>

                            <p>
                                {!! Purifier::clean($comment->content, 'blog_article') !!}
                            </p>
                        </div>
                    </div>
                @endforeach

                <div class="col-md 12 text-xs-center">
                    {{ $comments->render() }}
                </div>
            @elseif (Auth::user())
                <hr />
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    There's not comment yet. Post the first reply !
                </div>
            @endif

            <hr />
            @if (Auth::user())

                <div class="comment mb-2">
                    <div class="comment-media hidden-sm-down">
                        {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle', 'height' => '80px', 'width' => '80px']) }}
                    </div>
                    <div class="comment-content">
                        {!! Form::open(['route' => 'blog_comment_create']) !!}
                            {!! Form::hidden('article_id', $article->id) !!}
                            {!! Form::bsTextarea('content', false, old('message'), [
                                'placeholder' => 'Your message here...',
                                'required' => 'required',
                                'id' => 'commentBox'
                            ]) !!}
                            {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> Comment', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @else
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    You need to be logged in to comment to this article !
                </div>
            @endif

        </div>

        <div class="col-md-3">
            @include('Blog::article._sidebar')
        </div>

    </div>
</div>
@endsection
