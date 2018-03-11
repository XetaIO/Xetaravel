@extends('layouts.app')
{!! config(['app.title' => $conversation->title]) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $config = [
            'id' => 'editPostEditor'
        ];
    @endphp

    @if($conversation->is_locked == false)
        @php
            $config = [
                'id' => 'commentEditor',
                'height' => '350'
            ];
        @endphp
    @endif

    @include('editor/partials/_comment', $config)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="discuss-conversation-header-container pb-1 pt-4">
    <div class="blog-header mt-2">
        <div class="container text-xs-center">
            <ul class="discuss-conversation-header-badges d-inline-block">
                @if ($conversation->is_pinned)
                    <li class="discuss-conversation-header-badges-item">
                        <span class="tag tag-info" data-toggle="tooltip" title="Pinned">
                            <i class="fa fa-thumb-tack"></i>
                        </span>
                    </li>
                @endif

                @if ($conversation->is_locked)
                    <li class="discuss-conversation-header-badges-item">
                        <span class="tag tag-primary" data-toggle="tooltip" title="Locked">
                            <i class="fa fa-lock"></i>
                        </span>
                    </li>
                @endif
            </ul>

            @if ($conversation->is_solved)
                <div class="discuss-conversation-header-categories tag-group">
                    <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $conversation->category->color }};">
                        {{ $conversation->category->title }}
                    </a>
                    <span class="tag tag-success text-white">
                        Solved
                    </span>
                </div>
            @else
                <div class="discuss-conversation-header-categories">
                    <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default text-white" style="background-color: {{ $conversation->category->color }};">
                        {{ $conversation->category->title }}
                    </a>
                </div>
            @endif
            <h2 class="text-truncate">
                {{ $conversation->title }}
            </h2>
        </div>
    </div>
</div>
<hr class="mt-0" />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-3">
            <div class="sidebar-module">
                @auth
                    <div class="discuss-new-discussion-btn text-xs-center text-md-left">
                        <div class="btn-group">
                            @if (!$conversation->is_locked)
                                <a href="#post-reply" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Reply
                                </a>
                            @else
                                {{ link_to(
                                    route('discuss.conversation.create'),
                                    '<i class="fa fa-pencil"></i> Start a Discussion',
                                    ['class' => 'btn btn-primary'],
                                    true,
                                    false
                                ) }}
                            @endif

                            @if (
                                Auth::user()->hasPermission('manage.discuss.conversations') ||
                                Auth::user()->can('update', $conversation) ||
                                Auth::user()->can('delete', $conversation)
                            )
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @can('update', $conversation)
                                        <a class="dropdown-item" href="#editDiscussionModal" data-toggle="modal" data-target="#editDiscussionModal">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete', $conversation)
                                        @can('update', $conversation)
                                            <div class="dropdown-divider"></div>
                                        @endcan

                                        <a class="dropdown-item" href="#deleteDiscussionModal" data-toggle="modal" data-target="#deleteDiscussionModal">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            Delete
                                        </a>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="discuss-new-discussion-btn">
                        <a href="{{ route('users.auth.login') }}" class="btn btn-primary">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Reply
                        </a>
                    </div>
                @endauth

                @include('Discuss::partials._sidebar')
            </div>
        </div>

        {{-- Conversation Posts --}}
        <div class="col-md-9 mb-3">
            @forelse ($postsWithLogs as $post)
                @include(
                    'Discuss::partials._post',
                    [
                        'post' => $post,
                        'conversation' => $conversation,
                        'isFirstPost' => $conversation->first_post_id == $post->id ? true : false,
                        'isSolvedPost' => $conversation->solved_post_id == $post->id ? true : false
                    ]
                )
            @empty
                @if (!$conversation->is_solved && !$conversation->is_locked)
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There're no comments yet, post the first reply !
                    </div>
                @endif
            @endforelse

            <div class="col-md 12 text-xs-center">
                {{ $posts->render() }}
            </div>

            @if ($conversation->is_locked)
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    This discussion is closed, you can not reply !
                </div>
            @else
                @if (
                    $conversation->created_at <= \Carbon\Carbon::now()->subDays(config('xetaravel.discuss.info_message_old_conversation')) &&
                    !$conversation->is_locked
                )
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info" aria-hidden="true"></i>
                        This discussion is not active anymore since at least 3 months !
                    </div>
                @endif

                @auth
                    <div id="post-reply" class="discuss-conversation-comment mb-2">
                        <div class="discuss-conversation-comment-media float-xs-left hidden-sm-down">
                            {{ Html::image(Auth::user()->avatar_small, 'Avatar', ['class' => 'rounded-circle img-thumbnail']) }}
                        </div>
                        <div class="discuss-conversation-comment-content">
                            {!! Form::open(['route' => 'discuss.post.create']) !!}
                                {!! Form::hidden('conversation_id', $conversation->id) !!}

                                {!! Form::bsTextarea('content', false, old('message'), [
                                    'placeholder' => 'Your message here...',
                                    'required' => 'required',
                                    'editor' => 'commentEditor',
                                    'style' => 'display:none;'
                                ]) !!}

                                @permission ('manage.discuss.conversations')
                                    <div class="form-group">
                                        <h5 class="text-muted">
                                            Moderation
                                        </h5>
                                    </div>

                                    {!! Form::bsCheckbox(
                                        'is_locked',
                                        null,
                                        $conversation->is_locked,
                                        'Check to lock this discussion',
                                        [
                                            'label' => 'Is Locked ?',
                                            'labelClass' => 'custom-control custom-checkbox d-block'
                                        ]
                                    ) !!}

                                    {!! Form::bsCheckbox(
                                        'is_pinned',
                                        null,
                                        $conversation->is_pinned,
                                        'Check to pin this discussion',
                                        [
                                            'label' => 'Is Pinned ?',
                                            'labelClass' => 'custom-control custom-checkbox d-block'
                                        ]
                                    ) !!}
                                @endpermission

                                {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> Reply', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @else
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        You need to be logged in to comment to this discussion !
                    </div>
                @endauth
            @endif
        </div>
    </div>
</div>

{{-- Edit Conversation Modal --}}
<div class="modal fade" id="editDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="editDiscussionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscussionModalLabel">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    Edit the discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::model($conversation, [
                'route' => ['discuss.conversation.update', 'id' => $conversation->id, 'slug' => $conversation->slug],
                'method' => 'put'
            ]) !!}
                <div class="modal-body">
                    {!! Form::bsText(
                        'title',
                        null,
                        null,
                        [
                            'required' => 'required',
                            'placeholder' => 'Discussion title...'
                        ]
                    ) !!}

                    {!! Form::bsSelect(
                        'category_id',
                        $categories,
                        'Category',
                        null,
                        ['required' => 'required']
                    ) !!}

                    @permission ('manage.discuss.conversations')
                        <div class="form-group">
                            <h5 class="text-muted">
                                Moderation
                            </h5>
                        </div>

                        {!! Form::bsCheckbox(
                            'is_locked',
                            null,
                            null,
                            'Check to lock this discussion',
                            [
                                'label' => 'Is Locked ?',
                                'labelClass' => 'custom-control custom-checkbox d-block'
                            ]
                        ) !!}

                        {!! Form::bsCheckbox(
                            'is_pinned',
                            null,
                            null,
                            'Check to pin this discussion',
                            [
                                'label' => 'Is Pinned ?',
                                'labelClass' => 'custom-control custom-checkbox d-block'
                            ]
                        ) !!}
                    @endpermission
                </div>


                <div class="modal-actions">
                    {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i> Edit', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-primary']) !!}
                    <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Close
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Delete Conversation Modal --}}
<div class="modal fade" id="deleteDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="deleteDiscussionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDiscussionModalLabel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    Delete the discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::model($conversation, [
                'route' => ['discuss.conversation.delete', 'id' => $conversation->id, 'slug' => $conversation->slug],
                'method' => 'delete'
            ]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <p>
                            Are you sure you want delete this discussion ? <strong>This operation is not reversible.</strong>
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

{{-- Delete Post Modal --}}
<div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePostModalLabel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    Delete the post
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {!! Form::open([
                'route' => ['discuss.post.delete', 'id' => $post->id],
                'method' => 'delete',
                'id' => 'deletePostForm'
            ]) !!}

                <div class="modal-body">
                    <div class="form-group">
                        <p>
                            Are you sure you want delete this post ? <strong>This operation is not reversible.</strong>
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
@endsection