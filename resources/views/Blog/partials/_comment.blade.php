<article class="flex flex-col sm:flex-row" id="comment-{{ $comment->id }}">

    <aside class="flex flex-col items-center self-center sm:self-start mt-4">
        {{--  User Avatar --}}
        <a class="avatar {{ $comment->user->online ? 'avatar-online' : 'avatar-offline' }} m-2" href="{{ $comment->user->profile_url }}">
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

                {{-- User --}}
                <x-user.user
                    :user-name="$comment->user->full_name"
                    :user-avatar-small="$comment->user->avatar_small"
                    :user-profile="$comment->user->profile_url"
                    :user-last-login="$comment->user->last_login_date->diffForHumans()"
                    :user-registered="$comment->user->created_at->diffForHumans()"
                />

                <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                {{-- Date --}}
                <span class="tooltip" data-tip="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                    <time datetime="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                        {{ $comment->created_at->diffForHumans() }}
                    </time>
                </span>
            </div>

            {{-- Share --}}
            <x-blog.share :post-id="$comment->getKey()" :post-type="'BlogComment'" :route="route('blog.comment.show', ['id' => $comment->getKey()])" :is-solved="false" />
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
                    <div class="dropdown dropdown-end sm:opacity-0 sm:group-hover:opacity-100">
                        <div tabindex="0" role="button" class="btn btn-link m-1 dark:text-white text-neutral">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                            </svg>
                        </div>
                        <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
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
                                <li class="text-center opacity-70">
                                    Moderation
                                </li>
                                <li>
                                    <x-button class="btn-link text-red-500 tooltip" data-tip="Delete this comment"  icon="fas-trash-alt" icon-classes="h-4 w-4" label="Delete" @click="$wire.deleteCommentModal = true; $wire.deleteCommentId = {{ $comment->getKey() }}"/>
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
