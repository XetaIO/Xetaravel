<div class="inline-block xl:flex xl:flex-row items-center gap-2 {{ $log->type }}">
    {{-- Icon --}}
    <span class="mr-2 xl:mr-0">
        @if ($log->type == 'category')
            <x-icon name="fas-tag" class="h-6 w-6" />
        @elseif ($log->type == 'title')
            <x-icon name="fas-pencil" class="h-6 w-6" />
        @elseif ($log->type == 'locked')
            <x-icon name="fas-lock" class="h-6 w-6" />
        @elseif ($log->type == 'pinned')
            <x-icon name="fas-thumbtack" class="h-6 w-6" />
        @elseif ($log->type == 'deleted')
            <x-icon name="fas-trash" class="h-6 w-6" />
        @endif
    </span>

    {{-- User avatar --}}
    <figure class="inline-block w-5 h-5 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 mr-2 xl:mr-0">
        <img class="w-5 h-5 rounded-full" src="{{ $log->user->avatar_small }}"  alt="{{ $log->user->full_name }} avatar" />
    </figure>

    {{-- User --}}
    <x-user.user
        :user-name="$log->user->full_name"
        :user-avatar-small="$log->user->avatar_small"
        :user-profile="$log->user->profile_url"
        :user-last-login="$log->user->last_login_date->diffForHumans()"
        :user-registered="$log->user->created_at->diffForHumans()"
    />

    @php
    $time = "<time datetime=\"{$log->created_at->format('Y-m-d H:i:s')}\" data-toggle=\"tooltip\" title=\"{$log->created_at->format('Y-m-d H:i:s')}\">{$log->created_at->diffForHumans()}</time>";
    @endphp

    {{-- BlogCategory Changed --}}
    @if ($log->type == 'category')
        added the
        <a href="{{ $log->newCategory->category_url }}" class="flex items-center gap-1 px-1 rounded text-white" style="background-color: {{ $log->newCategory->color }};">
            @if (!is_null($log->newCategory->icon))
                <x-icon name="{{ $log->newCategory->icon }}" />
            @endif
            {{ $log->newCategory->title }}
        </a>
        and removed
        <a href="{{ $log->oldCategory->category_url }}" class="flex items-center gap-1 px-1 rounded text-white" style="background-color: {{ $log->oldCategory->color }};">
            @if (!is_null($log->oldCategory->icon))
                <x-icon name="{{ $log->oldCategory->icon }}" />
            @endif
            {{ $log->oldCategory->title }}
        </a>
        categories
        {!! $time !!}

    {{-- Title Changed --}}
    @elseif ($log->type == 'title')
        changed the title from
        <span class="font-bold">{{ $log->data['old'] }}</span>
        to
        <span class="font-bold">{{ $log->data['new'] }}</span>
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
        <x-user.user
            :user-name="$log->postUser->full_name"
            :user-avatar-small="$log->postUser->avatar_small"
            :user-profile="$log->postUser->profile_url"
            :user-last-login="$log->postUser->last_login_date->diffForHumans()"
            :user-registered="$log->postUser->created_at->diffForHumans()"
        />

        {!! $time !!}
    @endif
</div>
