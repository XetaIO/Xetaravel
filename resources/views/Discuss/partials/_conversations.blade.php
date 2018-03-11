<ul class="list-unstyled discuss-conversations-list">
    @forelse($conversations as $conversation)
        <li class="discuss-conversations-list-item">
            <div class="discuss-conversations-list-avatar float-xs-left">
                <ul class="discuss-conversations-list-badges">
                    @if ($conversation->is_pinned)
                        <li class="discuss-conversations-list-badges-item">
                            <span class="tag tag-info" data-toggle="tooltip" title="Pinned">
                                <i class="fa fa-thumb-tack"></i>
                            </span>
                        </li>
                    @endif

                    @if ($conversation->is_locked)
                        <li class="discuss-conversations-list-badges-item">
                            <span class="tag tag-primary" data-toggle="tooltip" title="Locked">
                                <i class="fa fa-lock"></i>
                            </span>
                        </li>
                    @endif
                </ul>

                @if ($conversation->is_solved)
                    <span class="discuss-conversations-list-user-solved rounded-circle">
                        <i class="fa fa-2x fa-check text-success" data-toggle="tooltip" title="This discussion is solved."></i>
                        <img src="{{ $conversation->user->avatar_small }}" alt="{{ $conversation->user->username }}" class="rounded-circle img-thumbnail" />
                    </span>
                @else
                    <img src="{{ $conversation->user->avatar_small }}" alt="{{ $conversation->user->username }}" class="rounded-circle img-thumbnail" />
                @endif
            </div>

            <div class="discuss-conversations-list-reply-count float-xs-right">
                <i class="fa fa-comment-o"></i> {{ $conversation->post_count_formated }}
            </div>

            <div class="discuss-conversations-list-content">
                <h6 class="text-truncate">
                    <a href="{{ route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey(), 'page' => $conversation->last_page]) }}">
                        {{ $conversation->title }}
                    </a>
                </h6>
                <div class="discuss-conversations-list-tags float-xs-right">
                    @if ($conversation->is_solved)
                        <div class="tag-group">
                            <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default" style="background-color: {{ $conversation->category->color }};">
                                {{ $conversation->category->title }}
                            </a>
                            <span class="tag tag-success">
                                Solved
                            </span>
                        </div>
                    @else
                        <a href="{{ route('discuss.category.show', ['slug' => $conversation->category->slug, 'id' =>$conversation->category->getKey()]) }}" class="tag tag-default" style="background-color: {{ $conversation->category->color }};">
                            {{ $conversation->category->title }}
                        </a>
                    @endif
                </div>
                <small>
                    @if ($conversation->first_post_id !== $conversation->last_post_id)
                        <i class="fa fa-reply"></i>
                        <discuss-user
                            :user="{{ json_encode($conversation->lastPost->user) }}"
                            :created-at="{{ var_export($conversation->lastPost->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($conversation->lastPost->user->last_login->diffForHumans()) }}"
                            :background-color="{{ var_export($conversation->lastPost->user->avatar_primary_color) }}">
                        </discuss-user>
                        replied
                        <time datetime="{{ $conversation->lastPost->created_at->format('c') }}" title="{{ $conversation->lastPost->created_at->format('c') }}" data-toggle="tooltip">
                            {{ $conversation->created_at->diffForHumans() }}
                        </time>
                    @else
                        <i class="fa fa-pencil"></i>
                        <discuss-user
                            :user="{{ json_encode($conversation->user) }}"
                            :created-at="{{ var_export($conversation->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($conversation->user->last_login->diffForHumans()) }}"
                            :background-color="{{ var_export($conversation->user->avatar_primary_color) }}">
                        </discuss-user>
                        started
                        <time datetime="{{ $conversation->created_at->format('c') }}" title="{{ $conversation->created_at->format('c') }}" data-toggle="tooltip">
                            {{ $conversation->created_at->diffForHumans() }}
                        </time>
                    @endif
                </small>
            </div>
        </li>
    @empty
        <div class="alert alert-primary" role="alert">
            <i class="fa fa-exclamation" aria-hidden="true"></i>
            There're no conversations yet.
        </div>
    @endforelse
</ul>

<div class="row">
    <div class="col-md 12 text-xs-center">
        {{ $conversations->render() }}
    </div>
</div>