@extends('layouts.app')
{!! config(['app.title' => $article->title]) !!}

@push('meta')
    <x-meta
        title="{{ $article->title }}"
        author="{{ $article->user->username }}"
        description="{!! Markdown::convertToHtml($article->content) !!}"
        url="{{ $article->article_url }}"
    />
@endpush

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $comment = [
            'id' => 'commentEditor',
            'height' => '350'
        ];
    @endphp

    @include('editor/partials/_comment', $comment)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="container pb-1 pt-4">
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
<div class="container pt-2 pb-4">
    <div class="row">

        <div class="col-md-9">
            <div class="blog-article">
                <div class="blog-article-meta">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <time datetime="{{ $article->created_at }}" title="{{ $article->created_at }}" data-toggle="tooltip">
                                {{ $article->created_at->diffForHumans() }}
                            </time>
                        </li>
                        <li class="list-inline-item">
                            <i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" title="Category"></i>
                            <a href="{{ $article->category->category_url }}">
                                {{ $article->category->title }}
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <i class="fa fa-comments"></i>
                            {{ $article->comment_count }}
                        </li>
                    </ul>
                </div>
                <img class="blog-article-banner mb-1" src="{{ $article->article_banner }}" alt="Article image">
                <div>
                    {!! Markdown::convertToHtml($article->content) !!}
                </div>
            </div>

            <div class="hr-divider">
                    <div class="hr-divider-content hr-divider-heading font-xeta">
                        Author
                    </div>
                </div>

            <div class="author">
                <div class="author-user float-xs-left text-xs-center">
                    @if ($article->user->hasRubies)
                        <i aria-hidden="true" class="fa fa-diamond text-primary comment-user-rubies"  data-toggle="tooltip" title="This user has earned Rubies."></i>
                    @endif
                    {{--  User Avatar --}}
                     <img class="author-user-media rounded-circle img-thumbnail" src="{{ asset($article->user->avatar_small) }}" alt="{{ $article->user->username }} Avatar">

                     {{-- Handle the user's icons --}}
                    @if ($article->user->hasRole(['member'], true))
                        <i aria-hidden="true" class="fas fa-user-tie author-user-roles author-user-member"  data-toggle="tooltip" title="Member"></i>
                    @endif

                    @if ($article->user->isModerator())
                        <i aria-hidden="true" class="fas fa-shield-alt author-user-roles author-user-moderator"  data-toggle="tooltip" title="Moderator"></i>
                    @endif

                    @if ($article->user->hasRole(['administrator', 'developer']))
                        <i aria-hidden="true" class="fas fa-wrench author-user-roles author-user-administrator"  data-toggle="tooltip" title="Administrator"></i>
                    @endif

                    @if ($article->user->isDeveloper())
                        <i aria-hidden="true" class="fas fa-code author-user-roles author-user-developer"  data-toggle="tooltip" title="Developer"></i>
                    @endif

                    @if ($article->user->online)
                        <span class="author-user-status">
                            <i class="online" data-toggle="tooltip" title="The user is online"></i>
                            <small class="online">Online</small>
                        </span>
                    @else
                        <span class="author-user-status">
                            <i data-toggle="tooltip" title="The user is offline"></i>
                            <small class="offline">Offline</small>
                        </span>
                    @endif
                </div>

                <div class="author-body">
                    <h2 class="author-body-title text-truncate font-xeta">
                        <discuss-user
                            :user="{{ json_encode([
                                'avatar_small'=> $article->user->avatar_small,
                                'profile_url' => $article->user->profile_url,
                                'full_name' => $article->user->full_name
                            ]) }}"
                            :created-at="{{ var_export($article->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($article->user->last_login->diffForHumans()) }}"
                            :background-color="{{ var_export($article->user->avatar_primary_color) }}">
                        </discuss-user>
                    </h2>

                    <p class="author-body-subtitle text-muted">
                        {!! Markdown::convertToHtml($article->user->signature) !!}
                    </p>
                </div>
            </div>


            <div class="comments">
                <div class="hr-divider">
                    <div class="hr-divider-content hr-divider-heading font-xeta">
                        {{ $article->comment_count }} Comment(s)
                    </div>
                </div>

                @forelse ($comments as $comment)
                    @include('Blog::partials._comment', ['comment' => $comment])
                @empty
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There're no comments yet, post the first reply !
                    </div>
                @endforelse
            </div>

            <div class="col-md 12 text-xs-center">
                {{ $comments->render() }}
            </div>
            <hr />

            @auth
                <div class="reply mb-2">
                    <div class="reply-media hidden-sm-down">
                        {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle', 'height' => '80px', 'width' => '80px']) }}
                    </div>
                    <div class="reply-content">
                        {!! Form::open(['route' => 'blog.comment.create']) !!}
                            {!! Form::hidden('article_id', $article->id) !!}

                            {!! Form::bsTextarea('content', false, old('message'), [
                                'placeholder' => 'Your message here...',
                                'required' => 'required',
                                'editor' => 'commentEditor',
                                'style' => 'display:none;'
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
            @include('Blog::partials._sidebar')
        </div>

    </div>
</div>

@auth
{{-- Delete Comment Modal --}}
<div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="deletePostModalLabel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    Delete the comment
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::open([
                'method' => 'delete',
                'id' => 'deleteCommentForm'
            ]) !!}

                <div class="modal-body">
                    <div class="form-group">
                        <p>
                            Are you sure you want delete this comment ? <strong>This operation is not reversible.</strong>
                        </p>
                    </div>
                </div>

                <div class="modal-actions">
                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Yes, I confirm !', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-danger']) !!}
                    <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Close
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endauth
@endsection
