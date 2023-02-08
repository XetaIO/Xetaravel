@extends('layouts.app')
{!! config(['app.title' => e($conversation->title)]) !!}

@push('meta')
  <x-meta
    title="{{ e($conversation->title) }}"
    author="{{ $conversation->user->username }}"
    description="{!! Markdown::convert($conversation->firstPost->content) !!}"
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
            'id' => 'editPostEditor'
        ];
    @endphp

    @if($conversation->is_locked == false)
        @php
            $comment = [
                'id' => 'commentEditor',
                'height' => '350'
            ];
        @endphp
    @endif

    @include('editor/partials/_comment', $comment)


    <script src="{{ asset('js/libs/highlight.min.js') }}"></script>
    <script type="text/javascript">
        // HighlightJS
        hljs.highlightAll();

        // DarkMode for highlight
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                el.classList.add('dark:bg-base-300', 'dark:text-slate-300');
            });
        });
    </script>
@endpush

@section('content')
<section class="discuss-conversation-header pb-1 pt-4">
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

            <div class="discuss-conversation-header-categories {{ $conversation->is_solved ? "tag-group" : "" }}">
                <a href="{{ $conversation->category->category_url }}" class="tag tag-default text-white" style="background-color: {{ $conversation->category->color }};">
                    @if (!is_null($conversation->category->icon))
                        <i class="{{ $conversation->category->icon }}"></i>
                    @endif
                    {{ $conversation->category->title }}
                </a>
                @if ($conversation->is_solved)
                    <span class="tag tag-success text-white">
                        <i class="fa fa-check" aria-hidden="true"></i> Solved
                    </span>
                @endif
            </div>

            <h2 class="text-truncate">
                {{ $conversation->title }}
            </h2>
        </div>
    </div>
</section>

<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Sidebar --}}
        <div class="lg:col-span-3 col-span-12 px-3">
            <div class="">
                @auth
                    <div class="form-control">
                        <div class="input-group">
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
                            <div class="dropdown btn btn-primary">
                                <label tabindex="0" class="m-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                    @can('update', $conversation)
                                        <li>
                                            <label class="editDiscussConversationModal" for="editDiscussConversationModal">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                Edit
                                            </label>
                                        </li>
                                    @endcan

                                    @can('delete', $conversation)
                                        @can('update', $conversation)
                                            <li class="dropdown-divider"></li>
                                        @endcan
                                        <li>
                                            <label class="text-red-500 deleteDiscussConversationModal" for="deleteDiscussConversationModal">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                Delete
                                            </label>
                                        </li>
                                    @endcan
                                </ul>
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
        <div class="lg:col-span-9 col-span-12 px-3">
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
</section>

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
<input type="checkbox" id="deleteDiscussConversationModal" class="modal-toggle" />
<div class="modal" role="dialog">
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