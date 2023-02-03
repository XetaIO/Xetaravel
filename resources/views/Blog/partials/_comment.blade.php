<article class="flex items-center" id="comment-{{ $comment->id }}">
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


    <div class="flex flex-col ml-3 self-start mt-5 w-full">
        {{-- Comment Meta --}}
        <div class="flex flex-row justify-between">
            <div class="flex flex-row items-center">
                {{-- User XP --}}
                <span class="font-semibold tooltip" data-tip="This user has {{ $comment->user->experiences_total }} XP">
                    <x-icon.star/>
                    {{ $comment->user->experiences_total }}
                </span>

                <span class="text-gray-700 mx-2"> - </span>

                {{-- User with Vue --}}
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

                <span class="text-gray-700 mx-2"> - </span>

                {{-- Date --}}
                <span class="tooltip" data-tip="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                    <time datetime="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                        {{ $comment->created_at->diffForHumans() }}
                    </time>
                </span>
                </ul>
            </div>

            {{-- Share --}}
            <discuss-share
                :post-id="{{ var_export($comment->getKey()) }}"
                :post-type="{{ var_export('Comment') }}"
                :route-input="{{ var_export(route('blog.comment.show', ['id' => $comment->getKey()])) }}">
            </discuss-share>
        </div>

        {{-- Comment Content --}}
        <div>
            {!! $comment->content_markdown !!}
        </div>

        <div class="flex flex-row justify-between">

            {{-- User Signature --}}
            <div class="self-start">
                @empty (!$comment->user->signature)
                {!! Markdown::convert($article->user->signature) !!}
                @endempty
            </div>

            {{-- Comment Actions --}}
            @auth
                @canany(['update', 'delete'], $comment)
                    <div class="dropdown dropdown-end self-end">
                    <label tabindex="0" class="btn btn-ghost m-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 h-5" viewBox="0 0 16 16">
                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Item 1</a></li>
                        <li><a>Item 2</a></li>
                    </ul>
                    </div>
                @endcan
            @endauth
        </div>

    </div>
</article>


<figure class="comment" id="comment-{{ $comment->id }}">
    <div class="comment-user float-xs-left text-xs-center">
        @if ($comment->user->hasRubies)
            <i aria-hidden="true" class="fa fa-diamond text-primary comment-user-rubies"  data-toggle="tooltip" title="This user has earned Rubies."></i>
        @endif

        {{--  User Avatar --}}
        <img src="{{ $comment->user->avatar_small }}" alt="{{ $comment->user->username }} Avatar" class="comment-user-media rounded-circle img-thumbnail" />

        {{-- Handle the user's icons --}}
        @if ($comment->user->hasRole(['member'], true))
            <i aria-hidden="true" class="fas fa-user-tie comment-user-roles comment-user-member"  data-toggle="tooltip" title="Member"></i>
        @endif

        @if ($comment->user->isModerator())
            <i aria-hidden="true" class="fas fa-shield-alt comment-user-roles comment-user-moderator"  data-toggle="tooltip" title="Moderator"></i>
        @endif

        @if ($comment->user->hasRole(['administrator', 'developer']))
            <i aria-hidden="true" class="fas fa-wrench comment-user-roles comment-user-administrator"  data-toggle="tooltip" title="Administrator"></i>
        @endif

        @if ($comment->user->isDeveloper())
            <i aria-hidden="true" class="fas fa-code comment-user-roles comment-user-developer"  data-toggle="tooltip" title="Developer"></i>
        @endif

        @if ($comment->user->online)
            <span class="comment-user-status">
                <i class="online" data-toggle="tooltip" title="The user is online"></i>
                <small class="online">Online</small>
            </span>
        @else
            <span class="comment-user-status">
                <i data-toggle="tooltip" title="The user is offline"></i>
                <small class="offline">Offline</small>
            </span>
        @endif
    </div>

    <div class="comment-post">

        {{-- Comment Meta --}}
        <div class="comment-post-meta">
            <ul class="list-inline mb-0">

                {{-- User XP --}}
                <li class="list-inline-item comment-post-meta-experiences" data-toggle="tooltip" title="This user has {{ $comment->user->experiences_total }} XP">
                    <i aria-hidden="true" class="fa fa-star"></i>
                    {{ $comment->user->experiences_total }}
                </li>

                {{-- User with Vue --}}
                <li class="list-inline-item font-weight-bold">
                    <i aria-hidden="true" class="fa fa-user"></i>
                    <discuss-user
                        :user="{{ json_encode([
                            'avatar_small'=> $article->user->avatar_small,
                            'profile_url' => $article->user->profile_url,
                            'full_name' => $article->user->full_name
                        ]) }}"
                        :created-at="{{ var_export($comment->user->created_at->diffForHumans()) }}"
                        :last-login="{{ var_export($comment->user->last_login->diffForHumans()) }}"
                        :background-color="{{ var_export($comment->user->avatar_primary_color) }}">
                    </discuss-user>
                </li>

                {{-- Date --}}
                <li class="list-inline-item" data-toggle="tooltip" title="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                    <i aria-hidden="true" class="fa fa-calendar"></i>
                    <time datetime="{{ $comment->created_at->format('Y-m-d H:i:s') }}">
                        {{ $comment->created_at->diffForHumans() }}
                    </time>
                </li>

                {{-- Share --}}
                <li class="comment-post-meta-share list-inline-item float-xs-right">
                    <discuss-share
                        :post-id="{{ var_export($comment->getKey()) }}"
                        :post-type="{{ var_export('Comment') }}"
                        :route-input="{{ var_export(route('blog.comment.show', ['id' => $comment->getKey()])) }}">
                    </discuss-share>
                </li>
            </ul>
        </div>

        {{-- Comment Content --}}
        <figcaption class="comment-post-content">
            {!! $comment->content_markdown !!}
        </figcaption>

        {{-- Comment Edit --}}
        <div class="comment-post-edit"></div>

        {{-- Comment Actions --}}
        @auth
            <div class="comment-post-actions">
                <ul class="list-inline mb-0">
                    @canany(['update', 'delete'], $comment)
                        {{-- Others actions --}}
                        <li class="list-inline-item float-xs-right">
                            <div class="dropdown">
                                <button href="#" class="btn btn-link" type="button" id="dropdownActionsMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-fw fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownActionsMenu">
                                    {{-- Moderation actions --}}
                                    {{--  @can('update', $comment)
                                        <a class="dropdown-item postEditButton" data-id="{{ $comment->getKey() }}" data-route="{{ route('discuss.post.editTemplate', ['id' => $comment->getKey()]) }}" href="#">
                                            <i class="fa fa-pencil"></i>
                                            Edit
                                        </a>
                                    @endcan--}}

                                    @can('delete', $comment)
                                        <div class="dropdown-header">Moderation</div>
                                        <a class="dropdown-item" data-toggle="modal" href="#deleteCommentModal" data-target="#deleteCommentModal" data-form-action="{{ route('blog.comment.delete', ['id' => $comment->getKey()]) }}">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </li>
                    @endcan
                </ul>
            </div>
        @endauth

        {{-- User Signature --}}
        @empty (!$comment->user->signature)
            <div class="comment-post-signature">
                {!! Markdown::convert($comment->user->signature) !!}
            </div>
        @endempty

    </div>
</figure>