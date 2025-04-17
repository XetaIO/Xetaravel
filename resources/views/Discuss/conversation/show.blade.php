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
                    <div class="join">
                        @if (!$conversation->is_locked)
                            <a href="#post-reply" class="btn btn-primary gap-2 join-item">
                                <x-icon name="fas-pencil" />
                                Reply
                            </a>
                        @else
                            @can('create', \Xetaravel\Models\DiscussConversation::class)
                                <x-button icon="fas-pencil" label="Start a Discussion" class="btn-primary gap-2 join-item conversationCreateButton" />
                            @endcan
                        @endif

                        @if (
                            Auth::user()->hasPermissionTo('manage discuss conversation') ||
                            Auth::user()->can('update', $conversation) ||
                            Auth::user()->can('delete', $conversation)
                        )
                        <div class="dropdown dropdown-end dropdown-bottom btn btn-primary join-item">
                            <div tabindex="0" role="button" class="m-1">
                                <x-icon name="fas-chevron-down" />
                            </div>
                            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm text-base-content">
                                @can('update', $conversation)
                                    <li>
                                        <a class="conversationUpdateButton tooltip" data-tip="Edit this conversation">
                                            <x-icon name="fas-pen-to-square" />
                                            Edit
                                        </a>
                                    </li>
                                @endcan

                                @can('delete', $conversation)
                                    @can('update', $conversation)
                                        <li class="dropdown-divider"></li>
                                    @endcan
                                    <li>
                                        <label class="conversationDeleteButton text-red-500 tooltip" data-tip="Delete this conversation">
                                            <x-icon name="fas-trash-can" />
                                            Delete
                                        </label>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                        @endif
                    </div>
                @else
                    <a href="{{ route('auth.login') }}" class="btn btn-primary gap-2">
                        <x-icon name="fas-pencil" />
                        Reply
                    </a>
                @endauth
            </div>

            @include('Discuss::partials._sidebar')
        </div>

        {{-- Conversation Posts --}}
        <div class="lg:col-span-9 col-span-12 mr-3 p-6 bg-base-100 dark:bg-base-300 shadow-md rounded-lg">
            <div class="mb-5">
                <h1 class="line-clamp-3 md:line-clamp-5 text-4xl mb-3">
                    {{ $conversation->title }}
                </h1>

                <ul class=" flex -flex-row text-white font-bold">
                    @if ($conversation->is_pinned)
                        <li class="flex px-2 first:rounded-l-md last:rounded-r-md bg-cyan-400">
                            <span class="tooltip flex items-center" data-tip="This conversation is pinned.">
                                <x-icon name="fas-thumbtack" />
                            </span>
                        </li>
                    @endif

                    @if ($conversation->is_locked)
                        <li class="flex px-2 first:rounded-l-md last:rounded-r-md bg-red-400">
                            <span class="tooltip flex items-center" data-tip="This conversation is locked.">
                                <x-icon name="fas-lock" />
                            </span>
                        </li>
                    @endif

                    <li class="px-2 first:rounded-l-md last:rounded-r-md" style="background-color: {{ $conversation->category->color }};">
                        <a href="{{ $conversation->category->show_url }}" class="tooltip flex items-center gap-1"  data-tip="Category">
                            @if (!is_null($conversation->category->icon))
                                <x-icon name="{{ $conversation->category->icon }}" />
                            @endif
                            {{ $conversation->category->title }}
                        </a>
                    </li>

                    @if ($conversation->is_solved)
                    <li class="flex px-2 first:rounded-l-md last:rounded-r-md bg-green-500">
                        <span class="tooltip flex items-center gap-1" data-tip="This conversation is solved.">
                                <x-icon name="fas-check" />
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
                        'isFirstPost' => $conversation->first_post_id == $post->id,
                        'isSolvedPost' => $conversation->solved_post_id == $post->id
                    ]
                )
            @empty
                @if (!$conversation->is_solved && !$conversation->is_locked)
                    <x-alert type="info">
                        There are no comments yet, post the first reply !
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
                @if ($conversation->created_at <= \Carbon\Carbon::now()->subDays(config('xetaravel.discuss.info_message_old_conversation')))
                    <x-alert type="info" class="dark:bg-base-200 mt-5">
                        This discussion is not active anymore since at least 3 months !
                    </x-alert>
                @endif

                {{--  Reply --}}
                @auth
                    <div class="divider text-lg font-bold">
                        <x-icon name="fas-reply" class="h-8 w-8" />
                        Reply
                    </div>
                    <div id="post-reply" class="flex flex-col sm:flex-row items-center">
                        <div class="self-start mx-auto">
                            {{--  User Avatar --}}
                            <a class="avatar online m-2" href="{{ Auth::user()->show_url }}">
                                <figure class="w-16 h-16 rounded-full ring-2 ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="Connected as {{ Auth::user()->username }}">
                                    <img class="rounded-full" src="{{ Auth::user()->avatar_small }}"  alt="{{ Auth::user()->full_name }} avatar" />
                                </figure>
                            </a>
                        </div>

                        {{-- Markdown --}}
                        <div class="self-start ml-3 mt-3 w-full">
                            <livewire:discuss.create-post :discussConversation="$conversation"/>
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

<livewire:discuss.update-post />
<livewire:discuss.delete-post />

{{-- Need to sort out of the dropdown menu --}}
@if ($conversation->is_locked && Auth::user()?->can('create', \Xetaravel\Models\DiscussConversation::class))
    <livewire:discuss.create-conversation />
@endif

@can('update', $conversation)
    <livewire:discuss.update-conversation :discussConversation="$conversation" />
@endcan

@can('delete', $conversation)
    <livewire:discuss.delete-conversation :discussConversation="$conversation" />
@endcan

@endsection
