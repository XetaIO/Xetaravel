<div class="discuss-conversation discuss-conversation-log discuss-conversation-log-{{ $log->type }}">
    <span class="discuss-conversation-log-icon">
        @if ($log->type == 'category')
            <i class="fa fa-tag"></i>
        @elseif ($log->type == 'title')
            <i class="fa fa-pencil"></i>
        @elseif ($log->type == 'locked')
            <i class="fa fa-lock"></i>
        @elseif ($log->type == 'pinned')
            <i class="fa fa-thumb-tack"></i>
        @elseif ($log->type == 'deleted')
            <i class="fa fa-trash"></i>
        @endif
    </span>
    <img src="{{ $log->user->avatar_small }}" class="rounded-circle" />
    <discuss-user
        :user="{{ json_encode([
            'avatar_small'=> $log->user->avatar_small,
            'profile_url' => $log->user->profile_url,
            'full_name' => $log->user->full_name
        ]) }}"
        :created-at="{{ var_export($log->user->created_at->diffForHumans()) }}"
        :last-login="{{ var_export($log->user->last_login->diffForHumans()) }}"
        :background-color="{{ var_export($log->user->avatar_primary_color) }}">
    </discuss-user>

    @php
    $time = "<time datetime=\"{$log->created_at->format('Y-m-d H:i:s')}\" data-toggle=\"tooltip\" title=\"{$log->created_at->format('Y-m-d H:i:s')}\">{$log->created_at->diffForHumans()}</time>";
    @endphp

    {{-- Category Changed --}}
    @if ($log->type == 'category')
        added the
        <a href="{{ route('discuss.category.show', ['slug' => $log->newCategory->slug, 'id' => $log->newCategory->id]) }}" class="tag tag-default text-white" style="background-color: {{ $log->newCategory->color }};">
            @if (!is_null($log->newCategory->icon))
                <i class="{{ $log->newCategory->icon }}"></i>
            @endif
            {{ $log->newCategory->title }}
        </a>
        and removed
        <a href="{{ route('discuss.category.show', ['slug' => $log->oldCategory->slug, 'id' => $log->oldCategory->id]) }}" class="tag tag-default text-white" style="background-color: {{ $log->oldCategory->color }};">
            @if (!is_null($log->oldCategory->icon))
                <i class="{{ $log->oldCategory->icon }}"></i>
            @endif
            {{ $log->oldCategory->title }}
        </a>
        categories
        {!! $time !!}

    {{-- Title Changed --}}
    @elseif ($log->type == 'title')
        changed the title from
        <strong>{{ $log->data['old'] }}</strong>
        to
        <strong>{{ $log->data['new'] }}</strong>
        {!! $time !!}

    {{-- Conversation Locked --}}
    @elseif ($log->type == 'locked')
        locked the discussion
        {!! $time !!}

    {{-- Conversation Pinned --}}
    @elseif ($log->type == 'pinned')
        pinned the discussion
        {!! $time !!}

    {{-- Post Deleted --}}
    @elseif ($log->type == 'deleted')
        deleted a comment from
        <discuss-user
            :user="{{ json_encode([
                'avatar_small'=> $log->postUser->avatar_small,
                'profile_url' => $log->postUser->profile_url,
                'full_name' => $log->postUser->full_name
            ]) }}"
            :created-at="{{ var_export($log->postUser->created_at->diffForHumans()) }}"
            :last-login="{{ var_export($log->postUser->last_login->diffForHumans()) }}"
            :background-color="{{ var_export($log->postUser->avatar_primary_color) }}">
        </discuss-user>

        {!! $time !!}
    @endif
</div>