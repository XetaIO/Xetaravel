
@if (get_class($post) !== \Xetaravel\Models\DiscussLog::class)
    <div class="discuss-thread {{ $solved ? 'discuss-thread-solved bg-success' : ''}}">
        <div class="discuss-thread-user float-xs-left text-xs-center">
            @if ($solved)
                <span class="discuss-thread-user-solved rounded-circle" data-toggle="tooltip" title="This response helped the author.">
                    <i class="fa fa-3x fa-check text-success"></i>
                    <img src="{{ $post->user->avatar_small }}" alt="{{ $post->user->username }}" class="rounded-circle img-thumbnail" />
                </span>
            @else
                <img src="{{ $post->user->avatar_small }}" alt="{{ $post->user->username }}" class="rounded-circle img-thumbnail" />
            @endif
        </div>

        <div class="discuss-thread-post">

            {{-- Thread Meta --}}
            <div class="discuss-thread-meta">
                <ul class="list-inline mb-0">

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
                    <li class="list-inline-item float-xs-right">
                        @if ($is_thread)
                            <discuss-share
                                :post-id="{{ var_export($post->getKey()) }}"
                                :route-input="{{ var_export(route('discuss.thread.show', ['slug' => $post->slug, 'id' => $post->getKey()])) }}">
                            </discuss-share>
                        @else
                            <discuss-share
                                :post-id="{{ var_export($post->getKey()) }}"
                                :route-input="{{ var_export(route('discuss.comment.show', ['id' => $post->getKey()])) }}">
                            </discuss-share>
                        @endif
                    </li>
                </ul>
            </div>

            {{-- Thread Content --}}
            <div class="discuss-thread-content">
                {!! $post->content_markdown !!}
            </div>

            {{-- Thread Actions --}}
            <div class="discuss-thread-actions">
                <ul class="list-inline mb-0">

                    {{-- Others actions --}}
                    <li class="list-inline-item float-xs-right">
                        <div class="dropdown">
                            <button href="#" class="btn btn-link" type="button" id="dropdownActionsMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownActionsMenu">
                                {{-- Moderation actions --}}
                                @can('update', $post)
                                    <a class="dropdown-item" href="#">Edit</a>
                                @endcan

                                @can('delete', $post)
                                    <h6 class="dropdown-header">Moderation</h6>
                                    <a class="dropdown-item" href="#">Delete</a>
                                @endcan
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
                    @if (!$thread->is_locked)
                        <li class="list-inline-item float-xs-right">
                            @auth
                                <a href="#" class="btn btn-link">
                                    Reply
                                </a>
                            @else
                                <a href="{{ route('users.auth.login') }}" class="btn btn-link">
                                    Reply
                                </a>
                            @endauth
                        </li>
                    @endif

                    {{-- Solved action --}}
                    @unless ($comment == false)
                        <li class="list-inline-item float-xs-right">
                            <a href="{{ route('discuss.comment.solved', ['id' => $post->id]) }}" class="btn btn-link text-success" data-toggle="tooltip" title="Mark this response as solved.">
                                <i class="fa fa-check"></i>
                            </a>
                        </li>
                    @endunless
                </ul>
            </div>

            {{-- User Signature --}}
            @empty (!$post->user->signature)
                <div class="discuss-thread-signature">
                    {!! Markdown::convertToHtml($post->user->signature) !!}
                </div>
            @endempty
        </div>
    </div>
@else
    @include('Discuss::partials._thread-log', ['log' => $post])
@endif