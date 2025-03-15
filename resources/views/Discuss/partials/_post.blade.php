@if (get_class($post) !== \Xetaravel\Models\DiscussLog::class)
    <article id="post-{{ $post->id }}" class="flex flex-col sm:flex-row {{ $isSolvedPost ? 'bg-green-500 text-white rounded' : ''}}">
        <aside class="flex flex-col items-center self-center sm:self-start mt-4">
            {{--  User Avatar --}}
            <a class="avatar {{ $post->user->online ? 'online' : 'offline' }} m-2" href="{{ $post->user->profile_url }}">
                @if ($isSolvedPost)
                    <figure class="w-16 h-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="This answer helped the author.">
                        <span class="absolute top-0 left-0 bottom-0 right-0 h-full w-full bg-white rounded-full opacity-60"></span>
                        <i class="absolute fa-solid fa-check text-4xl text-green-500 top-4 left-4"></i>
                @else
                    <figure class="w-16 h-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $post->user->username }} is {{ $post->user->online ? 'online' : 'offline' }}">
                @endif
                    <img class="rounded-full" src="{{ $post->user->avatar_small }}"  alt="{{ $post->user->full_name }} avatar" />
                </figure>
            </a>

            {{-- Handle the user's icons --}}
            <x-badge.role :user="$post->user" />
        </aside>



        <div class="flex flex-col sm:ml-3 self-start my-5 w-full group">
            {{-- Conversation Meta --}}
            <header class="flex flex-col sm:flex-row justify-between">
                <div class="flex flex-col sm:flex-row items-center">
                    {{-- User XP --}}
                    <span class="font-semibold tooltip" data-tip="This user has {{ $post->user->experiences_total }} XP">
                        <x-icon.star/>
                        {{ $post->user->experiences_total }}
                    </span>

                    <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                    {{-- User with Vue --}}
                    <discuss-user
                        class="text-xl font-xetaravel ml-0"
                        :user="{{ json_encode([
                            'avatar_small'=> $post->user->avatar_small,
                            'profile_url' => $post->user->profile_url,
                            'full_name' => $post->user->full_name
                        ]) }}"
                        :created-at="{{ var_export($post->user->created_at->diffForHumans()) }}"
                        :last-login="{{ var_export($post->user->last_login->diffForHumans()) }}"
                        :background-color="{{ var_export($post->user->avatar_primary_color) }}">
                    </discuss-user>

                    <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                    {{-- Date --}}
                    <span class="tooltip" data-tip="{{ $post->created_at->format('Y-m-d H:i:s') }}">
                        <time datetime="{{ $post->created_at->format('Y-m-d H:i:s') }}">
                            {{ $post->created_at->diffForHumans() }}
                        </time>
                    </span>

                    {{-- Edited --}}
                    @if ($post->is_edited)
                        <span class="text-gray-700 mx-2 hidden sm:inline-block"> - </span>

                        <span class="tooltip" data-tip="{{ $post->editedUser->username }} edited {{ $post->edited_at->diffForHumans() }}">
                            <i class="fa-solid fa-pencil"></i>
                            Edited
                        </span>
                    @endif
                </div>

                {{-- Share --}}
                <discuss-share
                    class="sm:opacity-0 sm:group-hover:opacity-100 sm:mr-3"
                    :is-solved="{{ var_export($isSolvedPost) }}"
                    :post-id="{{ var_export($post->getKey()) }}"
                    :post-type="{{ var_export('BlogComment') }}"
                    :route-input="{{ var_export(route('blog.comment.show', ['id' => $post->getKey()])) }}">
                </discuss-share>
            </header>


            {{-- Conversation Content --}}
            <div class="prose min-w-full my-4 {{ $isSolvedPost ? 'text-white' : 'text-current'}} discuss-conversation-content">
                {!! $post->content_markdown !!}
            </div>

            {{-- Conversation Edit --}}
            <div class="discuss-conversation-edit"></div>

            <footer class="flex flex-row justify-between border-t border-dashed border-slate-500 mr-2">
                {{-- User Signature --}}
                <div class="self-start">
                    @empty (!$post->user->signature)
                    {!! Markdown::convert($post->user->signature) !!}
                    @endempty
                </div>

                {{-- BlogComment Actions --}}
                @auth
                    <div class="flex flex-row-reverse items-center gap-2">
                        @canany(['update', 'delete'], $post)
                            <div class="dropdown dropdown-end self-start sm:opacity-0 sm:group-hover:opacity-100">
                                <label tabindex="0" class="btn btn-link m-1 text-current">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                    {{-- Moderation actions --}}
                                    @can('update', $post)
                                        <li>
                                            <label class="postEditButton" data-id="{{ $post->getKey() }}" data-route="{{ route('discuss.post.editTemplate', ['id' => $post->getKey()]) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                                Edit
                                            </label>
                                        </li>
                                    @endcan
                                    @if ($post->id !== $conversation->first_post_id)
                                        @can('delete', $post)
                                            <li class="text-center">
                                                Moderation
                                            </li>
                                            <li>
                                                <label class="deleteConversationPostModal text-red-500" for="deleteConversationPostModal" data-action="{{ route('discuss.post.delete', ['id' => $post->getKey()]) }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                    Delete
                                                </label>
                                            </li>
                                        @endcan
                                    @endif
                                </ul>
                            </div>
                        @endcan

                        {{-- Like action --}}
                        <!--<span class="sm:opacity-0 sm:group-hover:opacity-100">
                            <a href="#" class="btn btn-link">
                                Like
                            </a>
                        </span>-->

                        {{-- Reply action --}}
                        @if (!$conversation->is_locked)
                            <span class="sm:opacity-0 sm:group-hover:opacity-100">
                                @auth
                                    <a class="link link-hover link-primary postReplyButton" data-content="{{ '@' . $post->user->username }}#{{ $post->id }}" href="#post-reply">
                                        <i class="fa fa-reply"></i>
                                        Reply
                                    </a>
                                @else
                                    <label href="{{ route('auth.login') }}" class="link link-hover link-primary">
                                        <i class="fa fa-reply"></i>
                                        Reply
                                    </label>
                                @endauth
                            </span>
                        @endif

                        {{-- Solved action --}}
                        @if ($post->id !== $conversation->first_post_id && is_null($conversation->solved_post_id))
                            @can('solved', $conversation)
                                <span class="sm:opacity-0 sm:group-hover:opacity-100 px-2">
                                    <a href="{{ route('discuss.post.solved', ['id' => $post->id]) }}" class="link link-hover link-success tooltip" data-tip="Mark this response as solved.">
                                        <i class="fa-solid fa-check fa-lg"></i>
                                    </a>
                                </span>
                            @endcan
                        @endif
                    <div>
                @endauth
            </footer>

        </div>
    </article>
@else
    @include('Discuss::partials._log', ['log' => $post])
@endif

{{-- Divider between each post/logs --}}
@if (!$loop->last)
    <div class="divider"></div>
@endif
