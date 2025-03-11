<article class="flex flex-col sm:flex-row" id="comment-{{ $comment->id }}">

    <aside class="flex flex-col items-center self-center sm:self-start mt-4">
        {{--  User Avatar --}}
        <a class="avatar {{ $comment->user->online ? 'online' : 'offline' }} m-2" href="{{ $comment->user->profile_url }}">
            <figure class="w-16 h-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $comment->user->username }} is {{ $comment->user->online ? 'online' : 'offline' }}">
                <img class="rounded-full" src="{{ $comment->user->avatar_small }}"  alt="{{ $comment->user->full_name }} avatar" />
            </figure>
        </a>

        {{-- Handle the user's icons --}}
        <x-badge.role :user="$comment->user" />
    </aside>

    <div class="flex flex-col sm:ml-3 self-start mt-5 w-full group">
        {{-- BlogComment Meta --}}
        <header class="flex flex-col sm:flex-row justify-between">
            <div class="flex flex-col sm:flex-row items-center">
                {{-- User XP --}}
                <span class="font-semibold tooltip" data-tip="This user has {{ $comment->user->experiences_total }} XP">
                    <x-icon.star/>
                    {{ $comment->user->experiences_total }}
                </span>

                <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                {{-- User with Vue --}}
                <discuss-user
                    class="text-xl font-xetaravel ml-0"
                    :user="{{ json_encode([
                        'avatar_small'=> $comment->user->avatar_small,
                        'profile_url' => $comment->user->profile_url,
                        'full_name' => $comment->user->full_name
                    ]) }}"
                    :created-at="{{ var_export($comment->user->created_at->diffForHumans()) }}"
                    :last-login="{{ var_export($comment->user->last_login->diffForHumans()) }}"
                    :background-color="{{ var_export($comment->user->avatar_primary_color) }}">
                </discuss-user>

                <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                {{-- Date --}}
                <span class="tooltip" data-tip="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                    <time datetime="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                        {{ $comment->created_at->diffForHumans() }}
                    </time>
                </span>
            </div>

            {{-- Share --}}
            <discuss-share
                class="sm:opacity-0 sm:group-hover:opacity-100"
                :post-id="{{ var_export($comment->getKey()) }}"
                :post-type="{{ var_export('BlogComment') }}"
                :route-input="{{ var_export(route('blog.comment.show', ['id' => $comment->getKey()])) }}">
            </discuss-share>
        </header>

        {{-- BlogComment Content --}}
        <div class="prose min-w-full my-4">
            {!! $comment->content_markdown !!}
        </div>

        <footer class="flex flex-row justify-between">
            {{-- User Signature --}}
            <div class="self-start">
                @empty (!$comment->user->signature)
                {!! Markdown::convert($comment->user->signature) !!}
                @endempty
            </div>

            {{-- BlogComment Actions --}}
            @auth
                @canany(['update', 'delete'], $comment)
                    <div class="dropdown dropdown-end self-start sm:opacity-0 sm:group-hover:opacity-100">
                        <label tabindex="0" class="btn btn-link m-1 dark:text-white text-neutral">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                            </svg>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            {{-- Moderation actions --}}
                            {{--  @can('update', $comment)
                                <li>
                                    <a class="dropdown-item postEditButton" data-id="{{ $comment->getKey() }}" data-route="{{ route('discuss.post.editTemplate', ['id' => $comment->getKey()]) }}" href="#">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>
                                </li>
                            @endcan--}}
                            @can('delete', $comment)
                                <li class="text-center">
                                    Moderation
                                </li>
                                <li>
                                    <label class="deleteCommentModal text-red-500" for="deleteCommentModal" data-action="{{ route('blog.comment.delete', ['id' => $comment->getKey()]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Delete
                                    </label>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endcan
            @endauth
        </footer>

    </div>
</article>

{{-- Divider between each comment --}}
@if (!$loop->last)
    <div class="divider"></div>
@endif
