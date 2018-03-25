
@if (get_class($post) !== \Xetaravel\Models\DiscussLog::class)
    <div id="post-{{ $post->id }}" class="discuss-conversation {{ $isSolvedPost ? 'discuss-conversation-solved bg-success' : ''}}">
        <div class="discuss-conversation-user float-xs-left text-xs-center">
            @if ($isSolvedPost)
                <span class="discuss-conversation-user-solved rounded-circle" data-toggle="tooltip" title="This response helped the author.">
                    <i class="fa fa-3x fa-check text-success discuss-conversation-user-solved-icon"></i>

                    @if ($post->user->hasRubies)
                        <i aria-hidden="true" class="fa fa-diamond text-primary discuss-conversation-user-rubies"  data-toggle="tooltip" title="This user has earn Rubies."></i>
                    @endif

                    <img src="{{ $post->user->avatar_small }}" alt="{{ $post->user->username }}" class="rounded-circle img-thumbnail" />
                </span>
            @else
                @if ($post->user->hasRubies)
                    <i aria-hidden="true" class="fa fa-diamond text-primary discuss-conversation-user-rubies"  data-toggle="tooltip" title="This user has earn Rubies."></i>
                @endif

                <img src="{{ $post->user->avatar_small }}" alt="{{ $post->user->username }}" class="rounded-circle img-thumbnail" />
            @endif


        </div>

        <div class="discuss-conversation-post">

            {{-- Conversation Meta --}}
            <div class="discuss-conversation-meta">
                <ul class="list-inline mb-0">

                    <li class="list-inline-item discuss-conversation-post-meta-experiences" data-toggle="tooltip" title="This user has {{ $post->user->experiences_total }} XP">
                        <i aria-hidden="true" class="fa fa-star"></i>
                        {{ $post->user->experiences_total }}
                    </li>

                    {{-- User with Vue --}}
                    <li class="list-inline-item font-weight-bold">
                        <i aria-hidden="true" class="fa fa-user"></i>
                        <discuss-user
                            :user="{{ json_encode($post->user) }}"
                            :created-at="{{ var_export($post->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($post->user->last_login->diffForHumans()) }}"
                            :background-color="{{ var_export($post->user->avatar_primary_color) }}">
                        </discuss-user>
                    </li>

                    {{-- Date --}}
                    <li class="list-inline-item" data-toggle="tooltip" title="{{ $post->created_at->format('c') }}">
                        <i aria-hidden="true" class="fa fa-calendar"></i>
                        <time datetime="{{ $post->created_at->format('c') }}">
                            {{ $post->created_at->diffForHumans() }}
                        </time>
                    </li>

                    {{-- Edited --}}
                    @if ($post->is_edited)
                        <li class="list-inline-item">
                            <span data-toggle="tooltip" title="<strong>{{ $post->editedUser->username }}</strong> edited {{ $post->edited_at->diffForHumans() }}" data-html="true">
                                <i aria-hidden="true" class="fa fa-pencil"></i>
                                Edited
                            </span>
                        </li>
                    @endif

                    {{-- Share --}}
                    <li class="discuss-conversation-post-meta-share list-inline-item float-xs-right">
                        <discuss-share
                            :post-id="{{ var_export($post->getKey()) }}"
                            :post-type="{{ var_export('Post') }}"
                            :route-input="{{ var_export(route('discuss.post.show', ['id' => $post->getKey()])) }}">
                        </discuss-share>
                    </li>
                </ul>
            </div>

            {{-- Conversation Content --}}
            <div class="discuss-conversation-content">
                {!! $post->content_markdown !!}
            </div>

            {{-- Conversation Edit --}}
            <div class="discuss-conversation-edit"></div>

            {{-- Conversation Actions --}}
            <div class="discuss-conversation-actions">
                <ul class="list-inline mb-0">

                    {{-- Others actions --}}
                    <li class="list-inline-item float-xs-right">
                        <div class="dropdown">
                            <button href="#" class="btn btn-link" type="button" id="dropdownActionsMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownActionsMenu">
                                {{-- Moderation actions --}}
                                @can('update', $post)
                                    <a class="dropdown-item postEditButton" data-id="{{ $post->getKey() }}" data-route="{{ route('discuss.post.editTemplate', ['id' => $post->getKey()]) }}" href="#">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>
                                @endcan

                                @if ($post->id !== $conversation->first_post_id)
                                    @can('delete', $post)
                                        <h6 class="dropdown-header">Moderation</h6>
                                        <a class="dropdown-item" data-toggle="modal" href="#deletePostModal" data-target="#deletePostModal" data-form-action="{{ route('discuss.post.delete', ['id' => $post->getKey()]) }}">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    </li>

                    {{-- Like action --}}
                    <!--<li class="list-inline-item float-xs-right">
                        <a href="#" class="btn btn-link">
                            Like
                        </a>
                    </li>-->

                    {{-- Reply action --}}
                    @if (!$conversation->is_locked)
                        <li class="list-inline-item float-xs-right">
                            @auth
                                <a href="#" class="btn btn-link postReplyButton" data-content="{{ '@' . $post->user->username }}#{{ $post->id }}">
                                    <i class="fa fa-reply"></i>
                                    Reply
                                </a>
                            @else
                                <a href="{{ route('users.auth.login') }}" class="btn btn-link">
                                    <i class="fa fa-reply"></i>
                                    Reply
                                </a>
                            @endauth
                        </li>
                    @endif

                    {{-- Solved action --}}
                    @if ($post->id !== $conversation->first_post_id && is_null($conversation->solved_post_id))
                        <li class="list-inline-item float-xs-right">
                            <a href="{{ route('discuss.post.solved', ['id' => $post->id]) }}" class="btn btn-link text-success" data-toggle="tooltip" title="Mark this response as solved.">
                                <i class="fa fa-check"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- User Signature --}}
            @empty (!$post->user->signature)
                <div class="discuss-conversation-signature">
                    {!! Markdown::convertToHtml($post->user->signature) !!}
                </div>
            @endempty
        </div>
    </div>
@else
    @include('Discuss::partials._log', ['log' => $post])
@endif