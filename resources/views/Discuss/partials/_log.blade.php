<div class="inline-block xl:flex xl:flex-row items-center gap-2 {{ $log->type }}">
    {{-- Icon --}}
    <span class="mr-2 xl:mr-0">
        @if ($log->type == 'category')
            <i class="fa-solid fa-tag fa-xl"></i>
        @elseif ($log->type == 'title')
            <i class="fa-solid fa-pencil fa-xl"></i>
        @elseif ($log->type == 'locked')
            <i class="fa-solid fa-lock fa-xl"></i>
        @elseif ($log->type == 'pinned')
            <i class="fa-solid fa-thumbtack  fa-xl"></i>
        @elseif ($log->type == 'deleted')
            <i class="fa-solid fa-trash  fa-xl"></i>
        @endif
    </span>

    {{-- User avatar --}}
    <figure class="inline-block w-5 h-5 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 mr-2 xl:mr-0">
        <img class="w-5 h-5 rounded-full" src="{{ $post->user->avatar_small }}"  alt="{{ $post->user->full_name }} avatar" />
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
        <a href="{{ $log->newCategory->category_url }}" class="px-1 rounded text-white" style="background-color: {{ $log->newCategory->color }};">
            @if (!is_null($log->newCategory->icon))
                <i class="{{ $log->newCategory->icon }}"></i>
            @endif
            {{ $log->newCategory->title }}
        </a>
        and removed
        <a href="{{ $log->oldCategory->category_url }}" class="px-1 rounded text-white" style="background-color: {{ $log->oldCategory->color }};">
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
