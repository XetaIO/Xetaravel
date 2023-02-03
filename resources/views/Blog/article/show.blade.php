@extends('layouts.app')
{!! config(['app.title' => $article->title]) !!}

@push('meta')
    <x-meta
        title="{{ $article->title }}"
        author="{{ $article->user->username }}"
        description="{!! Markdown::convert($article->content) !!}"
        url="{{ $article->article_url }}"
    />
@endpush

@push('style')
    {!! editor_css() !!}
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


    <script src="{{ asset('js/libs/highlight.min.js') }}"></script>
    <script type="text/javascript">
        // HighlightJS
        hljs.highlightAll();
    </script>
@endpush

@section('content')
<!-- Breadcrumbs -->
<section class="lg:container mx-auto mt-12 mb-5  overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<!-- Article -->
<section class="lg:container mx-auto  overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-9 col-span-12 px-3">

            <article class="bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg px-6 pb-6 mb-10">
                <header class="mb-6">
                    <h1 class="text-4xl font-xetaravel py-8">
                        {{ $article->title }}
                    </h1>
                    <div class="flex justify-between items-center mt-2">
                        <div class="flex justify-center items-center">
                            <a href="{{ $article->user->profile_url }}">
                                <img class="rounded-full mr-2" src="{{ asset($article->user->avatar_small) }}" width="40" height="40" alt="{{ $article->user->username }} Avatar">
                            </a>
                            <div>
                                <time class="tooltip" datetime="{{ $article->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $article->created_at->format('Y-m-d H:i:s') }}">
                                    {{ $article->created_at->formatLocalized('%b %d, %Y') }}
                                </time>
                                <span class="text-gray-700"> - </span>
                                <span class="font-semibold tooltip" data-tip="Comments">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>

                                    {{ $article->comment_count }}
                                </span>
                                @permission('manage.blog')
                                    <span class="text-gray-700"> - </span>
                                    <a class="btn btn-sm" href="{{ route('admin.blog.article.edit', ['slug' => $article->slug, 'id' => $article->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-3 w-3 mr-1" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                        </svg>
                                        Edit
                                    </a>
                                @endpermission
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <ul class="flex flex-wrap">
                                <li class="m-1">
                                    <a class="badge badge-outline badge-lg tooltip inline-flex" href="{{ $article->category->category_url }}" data-tip="Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg>
                                        {{ $article->category->title }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>

                <figure class="max-h-[350px] min-h-[100px] xs:min-h-[250px] max-w-[870px] mx-auto mb-6 overflow-hidden">
                    <img class="w-full h-full object-cover" src="{{ $article->article_banner }}" alt="Article image">
                </figure>

                <div class="prose min-w-full">
                    {!! Markdown::convert($article->content) !!}
                </div>

                <footer class="my-10">
                    <h3 class="divider mb-4 text-xl font-bold">
                        Author
                    </h3>
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <a class="avatar {{ $article->user->online ? 'online' : 'offline' }} m-2" href="{{ $article->user->profile_url }}">
                                <figure class="w-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $article->user->username }} is {{ $article->user->online ? 'online' : 'offline' }}">
                                    <img class="rounded-full" src="{{ $article->user->avatar_small }}"  alt="{{ $article->user->full_name }} avatar" />
                                </figure>
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                {{-- Handle the user's icons --}}
                                @if ($article->user->hasRole(['member'], true))
                                    <div class="col-span-1">
                                        <x-icon.member/>
                                    </div>
                                @endif

                                @if ($article->user->isModerator())
                                    <div class="col-span-1">
                                        <x-icon.moderator/>
                                    </div>
                                @endif

                                @if ($article->user->hasRole(['administrator', 'developer']))
                                    <div class="col-span-1">
                                        <x-icon.administrator/>
                                    </div>
                                @endif

                                @if ($article->user->isDeveloper())
                                    <div class="col-span-1">
                                        <x-icon.developer/>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col ml-3 self-start mt-5">
                            <discuss-user
                                class="text-xl font-xetaravel ml-0"
                                :user="{{ json_encode([
                                    'avatar_small'=> $article->user->avatar_small,
                                    'profile_url' => $article->user->profile_url,
                                    'full_name' => $article->user->full_name
                                ]) }}"
                                :created-at="{{ var_export($article->user->created_at->diffForHumans()) }}"
                                :last-login="{{ var_export($article->user->last_login->diffForHumans()) }}"
                                :background-color="{{ var_export($article->user->avatar_primary_color) }}">
                            </discuss-user>
                            <div>
                                {!! Markdown::convert($article->user->signature) !!}
                            </div>
                        </div>
                    </div>
                </footer>
            </article>

            <section>
                <h2 class="mb-4 text-xl font-bold">
                    {{ $article->comment_count }} Comment(s)
                </h2>

                <div>
                    @forelse ($comments as $comment)
                        @include('Blog::partials._comment', ['comment' => $comment])
                    @empty
                        <div class="alert alert-primary" role="alert">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            There're no comments yet, post the first reply !
                        </div>
                    @endforelse
                </div>

            </section>

        </div>
        <aside class="lg:col-span-3 col-span-12 px-3">
            @include('Blog::partials._sidebar')
        </aside>
    </div>
</section>


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
                        {!! Markdown::convert($article->user->signature) !!}
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
