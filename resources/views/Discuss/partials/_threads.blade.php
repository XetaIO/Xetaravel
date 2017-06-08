<ul class="list-unstyled discuss-threads-list">
    @forelse($threads as $thread)
        <li class="discuss-threads-list-item">
            <div class="discuss-threads-list-avatar float-xs-left">
                <img class="img-thumbnail" src="{{ $thread->user->avatar_small }}" width="50" />
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <span><i class="fa fa-locked"></i></span>
                    </li>
                    <li class="list-inline-item">
                        <span><i class="fa fa-locked"></i></span>
                    </li>
                </ul>
            </div>
            <div class="discuss-threads-list-reply-count float-xs-right">
                <i class="fa fa-comment-o"></i> {{ $thread->comment_count }}
            </div>
            <div class="discuss-threads-list-content">
                <h6 class="text-truncate">
                    <a href="{{ route('discuss.thread.show', ['slug' => $thread->slug, 'id' => $thread->getKey(), 'page' => $thread->last_page]) }}">
                        {{ $thread->title }}
                    </a>
                </h6>
                <div class="discuss-threads-list-tags float-xs-right">
                    @if (!$thread->is_solved)
                        <div class="tag-group">
                            <a href="{{ route('discuss.category.show', ['slug' => $thread->category->slug, 'id' =>$thread->category->getKey()]) }}" class="tag tag-default" style="background-color: {{ $thread->category->color }};">
                                {{ $thread->category->title }}
                            </a>
                            <span class="tag tag-success">
                                Solved
                            </span>
                        </div>
                    @else
                        <a href="{{ route('discuss.category.show', ['slug' => $thread->category->slug, 'id' =>$thread->category->getKey()]) }}" class="tag tag-default" style="background-color: {{ $thread->category->color }};">
                            {{ $thread->category->title }}
                        </a>
                    @endif
                </div>
                <small>
                    @if (!is_null($thread->lastComment))
                        <i class="fa fa-reply"></i>
                        <discuss-user
                            :user="{{ json_encode($thread->lastComment->user) }}"
                            :created-at="{{ var_export($thread->lastComment->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($thread->lastComment->user->last_login->diffForHumans()) }}">
                        </discuss-user>
                        replied
                        <time datetime="{{ $thread->lastComment->created_at->format('c') }}" title="{{ $thread->lastComment->created_at->format('c') }}" data-toggle="tooltip">
                            {{ $thread->created_at->diffForHumans() }}
                        </time>
                    @else
                        <i class="fa fa-pencil"></i>
                        <discuss-user
                            :user="{{ json_encode($thread->user) }}"
                            :created-at="{{ var_export($thread->user->created_at->diffForHumans()) }}"
                            :last-login="{{ var_export($thread->user->last_login->diffForHumans()) }}">
                        </discuss-user>
                        started
                        <time datetime="{{ $thread->created_at->format('c') }}" title="{{ $thread->created_at->format('c') }}" data-toggle="tooltip">
                            {{ $thread->created_at->diffForHumans() }}
                        </time>
                    @endif
                </small>
            </div>
        </li>
    @empty
        There're no threads yet.
    @endforelse
</ul>

<div class="row">
    <div class="col-md 12 text-xs-center">
        {{ $threads->render() }}
    </div>
</div>