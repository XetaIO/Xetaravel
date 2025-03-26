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
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@endpush

@push('scripts')
    @vite('resources/js/highlight.js')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // HighlightJS
            hljs.highlightAll();
        });
    </script>
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
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Sidebar --}}
        <div class="lg:col-span-3 col-span-12 px-3">
            <div class="mb-5">
                @auth
                    <div class="form-control">
                        <div class="input-group">
                            @if (!$conversation->is_locked)
                                <a href="#post-reply" class="btn btn-primary gap-2">
                                    <i class="fa-solid fa-pencil"></i>
                                    Reply
                                </a>
                            @else
                                <a class="btn btn-primary gap-2" href="{{ route('discuss.index', ['creating' => true]) }}">
                                    <i class="fa-solid fa-pencil"></i>
                                    Start a Discussion
                                </a>
                            @endif

                            @if (
                                Auth::user()->hasPermissionTo('manage discuss conversation') ||
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
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 text-base-content dark:text-white">
                                    @can('update', $conversation)
                                        <li>
                                            <label class="editDiscussConversationModal" for="editDiscussConversationModal">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Edit
                                            </label>
                                        </li>
                                    @endcan

                                    @can('delete', $conversation)
                                        @can('update', $conversation)
                                            <li class="dropdown-divider"></li>
                                        @endcan
                                        <li>
                                            <label class="deleteDiscussConversationModal text-red-500 " for="deleteDiscussConversationModal">
                                                <i class="fa-solid fa-trash-can"></i>
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
                    <a href="{{ route('auth.login') }}" class="btn btn-primary gap-2">
                        <i class="fa-solid fa-pencil"></i>
                        Reply
                    </a>
                @endauth
            </div>

            @include('Discuss::partials._sidebar')
        </div>

        {{-- Conversation Posts --}}
        <div class="lg:col-span-9 col-span-12 p-6 bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg">
            <div class="mb-5">
                <h1 class="line-clamp-3 md:line-clamp-5 text-4xl font-xetaravel mb-3">
                    {{ $conversation->title }}
                </h1>

                <ul class=" flex -flex-row text-white font-bold">
                    @if ($conversation->is_pinned)
                        <li class="px-2 first:rounded-l-md last:rounded-r-md bg-cyan-400">
                            <span class="tooltip" data-tip="This conversation is pinned.">
                                <i class="fa-solid fa-thumbtack"></i>
                            </span>
                        </li>
                    @endif

                    @if ($conversation->is_locked)
                        <li class="px-2 first:rounded-l-md last:rounded-r-md bg-red-400">
                            <span class="tooltip" data-tip="This conversation is locked.">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                        </li>
                    @endif

                    <li class="px-2 first:rounded-l-md last:rounded-r-md" style="background-color: {{ $conversation->category->color }};">
                        <a href="{{ $conversation->category->category_url }}" class="tooltip"  data-tip="Category">
                            @if (!is_null($conversation->category->icon))
                                <i class="{{ $conversation->category->icon }}"></i>
                            @endif
                            {{ $conversation->category->title }}
                        </a>
                    </li>

                    @if ($conversation->is_solved)
                    <li class="px-2 first:rounded-l-md last:rounded-r-md bg-green-500">
                        <span class="tooltip" data-tip="This conversation is solved.">
                            <i class="fa-solid fa-check"></i>
                            Solved
                        </span>
                    </li>
                    @endif
                </ul>
            </div>

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
                    <x-alert type="primary" class="dark:bg-base-200 mt-5">
                        There're no comments yet, post the first reply !
                    </x-alert>
                @endif
            @endforelse

            {{-- Posts pagination --}}
            <div class="grid grid-cols-1">
                {{ $posts->links() }}
            </div>

            @if ($conversation->is_locked)
                <x-alert type="primary" class="dark:bg-base-200 mt-5">
                    This discussion is closed, you can not reply !
                </x-alert>
            @else
                @if (
                    $conversation->created_at <= \Carbon\Carbon::now()->subDays(config('xetaravel.discuss.info_message_old_conversation')) &&
                    !$conversation->is_locked
                )
                    <x-alert type="info" class="dark:bg-base-200 mt-5">
                        This discussion is not active anymore since at least 3 months !
                    </x-alert>
                @endif

                {{--  Reply --}}
                @auth
                    <div class="divider text-lg font-bold">
                        <i class="fa-solid fa-reply"></i>
                        Reply
                    </div>
                    <div id="post-reply" class="flex flex-col sm:flex-row items-center">
                        <div class="self-start mx-auto">
                            {{--  User Avatar --}}
                            <a class="avatar online m-2" href="{{ Auth::user()->profile_url }}">
                                <figure class="w-16 h-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="Connected as {{ Auth::user()->username }}">
                                    <img class="rounded-full" src="{{ Auth::user()->avatar_small }}"  alt="{{ Auth::user()->full_name }} avatar" />
                                </figure>
                            </a>
                        </div>

                        {{-- Reply --}}
                        <div class="self-start ml-3 mt-3 w-full">

                        </div>
                    </div>
                @else
                    <x-alert type="primary" class="dark:bg-base-200 mt-5">
                        You need to be logged in to comment to this discussion !
                    </x-alert>
                @endauth
            @endif
        </div>
    </div>
</section>

{{-- Edit Conversation Modal --}}
<input type="checkbox" id="editDiscussConversationModal" class="modal-toggle" />
<label for="editDiscussConversationModal" class="modal cursor-pointer">
    <label class="modal-box relative">
        <label for="editDiscussConversationModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="font-bold text-lg">
            Edit the discussion
        </h3>


    </label>
</label>

{{-- Delete Conversation Modal --}}
<input type="checkbox" id="deleteDiscussConversationModal" class="modal-toggle" />
<label for="deleteDiscussConversationModal" class="modal cursor-pointer">
    <label class="modal-box relative">
        <label for="deleteDiscussConversationModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="font-bold text-lg">
            Delete the discussion
        </h3>

    </label>
</label>

{{-- Delete Post Modal --}}
<input type="checkbox" id="deleteConversationPostModal" class="modal-toggle" />
<label for="deleteConversationPostModal" class="modal cursor-pointer">
    <label class="modal-box relative">
        <label for="deleteConversationPostModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="font-bold text-lg">
            Delete the post
        </h3>

    </label>
</label>

@endsection
