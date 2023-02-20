
<div>

    <div class="flex flex-col xl:flex-row xl:justify-between gap-2 mb-5">
        {{-- Categories selection --}}
        <div class="relative flex flex-col sm:flex-row gap-2">
            <button
                wire:click.defer="toggle"
                class="input input-bordered w-full sm:w-[250px] flex items-center justify-between "
                type="button"
            >
                <span class="flex items-center gap-2" style="color:{{ $categories[$category]['color'] }}">
                    @if (!is_null($categories[$category]['icon']))
                        <i class="{{ $categories[$category]['icon'] }}"></i>
                    @endif
                    {{ $categories[$category]['title'] }}
                </span>

                <div>
                    @if ($open)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                            clip-rule="evenodd"/>
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"/>
                    </svg>
                    @endif
                </div>
            </button>
            @if ($open)
            <ul class="absolute bg-base-200 rounded-lg h-[150px] w-full sm:w-[250px] overflow-hidden overflow-y-scroll z-20">
                @foreach($categories as $cat)
                    <li wire:click="select({{ $cat['id'] }})"
                        @class([
                            'px-3 py-2 cursor-pointer flex items-center justify-between',
                            'bg-[color:hsl(var(--p))] text-white' => $category === $cat['id'],
                            'hover:bg-[color:hsl(var(--p))] hover:text-white',
                        ])
                    >
                        <span class="flex items-center gap-2">
                            @if (!is_null($cat['icon']))
                                <i class="{{ $cat['icon'] }}"></i>
                            @endif
                            {{ $cat['title'] }}
                        </span>

                        @if ($category === $cat['id'])
                        <div class="text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
            {{-- Order by list --}}
            <div class="flex w-full sm:w-fit">
                <select wire:model="sortField" name="limit" class="select select-bordered w-full sm:w-fit" title="">
                    <option value="created_at">Reset filter</option>
                    <option value="created_at">Last Conversations</option>
                    <option value="is_solved">Solved</option>
                    <option value="is_locked">Locked</option>
                    <option value="post_count">Most Commented</option>
                </select>
            </div>
        </div>

        {{-- Search input --}}
        <div class="flex flex-col w-full xl:w-fit xl:flex-row self-start xl:self-end gap-2">
            <div class="w-full sm:w-fit">
            <span class="hidden xl:inline-block">Limit</span>
            <select wire:model="limit" name="limit" class="select select-bordered w-full sm:w-fit" title="Limit conversations">
                @foreach ($perPage as $page)
                    <option value="{{ $page }}" {{ $limit == $page ? 'selected' : '' }}>{{ $page == config('xetaravel.pagination.discuss.conversation_per_page') ? 'Default (' . $page . ')' : $page }}</option>
                @endforeach
            </select>
        </div>
            <div class="relative w-full xl:w-fit">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model="search" placeholder="Search conversations..." type="text" class="input input-bordered pl-10 w-full xl:min-w-[250px]">
            </div>
        </div>
    </div>

    <ul class="mb-4">
    @forelse($conversations as $conversation)
        <li class="flex flex-col sm:flex-row border border-gray-200 p-3 px-5 rounded dark:bg-base-300 dark:border-gray-700 hover:bg-base-200 dark:hover:bg-base-200 {{ !$loop->first ? 'mt-3' : '' }}" wire:loading.class.delay="opacity-50">

            <div class="flex flex-row justify-between w-full relative">
                {{--  Locked & Pinned --}}
                @if ($conversation->is_pinned == true && $conversation->is_locked == true)
                    <span class="tooltip" data-tip="This conversation is pinned.">
                        <span class="absolute -left-7 -top-2 text-white bg-cyan-400 rounded rounded-r-none rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-cyan-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                            <i class="fa-solid fa-thumbtack h-[16px] w-[16px]"></i>
                        </span>
                    </span>
                    <span class="tooltip" data-tip="This conversation is locked.">
                        <span class="absolute -left-1 -top-2 text-white bg-red-400 rounded rounded-l-none color-white font-semibold shadow-md p-1 z-10">
                            <i class="fa-solid fa-lock h-[16px] w-[16px]"></i>
                        </span>
                    </span>
                @elseif($conversation->is_pinned == false && $conversation->is_locked == true)
                    <span class="tooltip" data-tip="This conversation is locked.">
                        <span class="absolute -left-7 -top-2 text-white bg-red-400 rounded rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-red-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                            <i class="fa-solid fa-lock h-[16px] w-[16px]"></i>
                        </span>
                    </span>
                @elseif($conversation->is_pinned == true && $conversation->is_locked == false)
                    <span class="tooltip" data-tip="This conversation is pinned.">
                        <span class="absolute -left-7 -top-2 text-white bg-cyan-400 rounded rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-cyan-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                            <i class="fa-solid fa-thumbtack h-[16px] w-[16px]"></i>
                        </span>
                    </span>
                @endif

                {{--  User Avatar --}}
                <div class="hidden sm:flex flex-col">
                    <a class="avatar {{ $conversation->user->online ? 'online' : 'offline' }} m-2" href="{{ $conversation->user->profile_url }}">
                        <figure class="w-12 h-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $conversation->user->username }} is {{ $conversation->user->online ? 'online' : 'offline' }}">
                            <img class="rounded-full" src="{{ $conversation->user->avatar_small }}"  alt="{{ $conversation->user->full_name }} avatar" />
                        </figure>
                    </a>
                </div>

                {{-- Title, Content & Meta --}}
                <div class="flex flex-col justify-between gap-2 w-full px-2">
                    {{-- Title --}}
                    <h4 class="line-clamp-3 md:line-clamp-1">
                        <a class="link link-hover text-primary text-xl font-semibold" href="{{ route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey(), 'page' => $conversation->last_page]) }}" title="{{ $conversation->title }}">
                            {{ $conversation->title }}
                        </a>
                    </h4>

                    {{-- Content --}}
                    <div class="line-clamp-3 md:line-clamp-2">
                        {!! strip_tags(Markdown::convert(Str::limit($conversation->firstPost->content, 550))) !!}
                    </div>

                    {{-- Meta --}}
                    <div class="flex flex-col md:flex-row items-start  md:items-center">
                        {{-- User --}}
                        <div>
                            @if ($conversation->first_post_id !== $conversation->last_post_id)
                                <i class="fa-solid fa-reply"></i>
                                <discuss-user
                                    :user="{{ json_encode([
                                        'avatar_small'=> $conversation->lastPost->user->avatar_small,
                                        'profile_url' => $conversation->lastPost->user->profile_url,
                                        'full_name' => $conversation->lastPost->user->full_name
                                    ]) }}"
                                    :created-at="{{ var_export($conversation->lastPost->user->created_at->diffForHumans()) }}"
                                    :last-login="{{ var_export($conversation->lastPost->user->last_login->diffForHumans()) }}"
                                    :background-color="{{ var_export($conversation->lastPost->user->avatar_primary_color) }}">
                                </discuss-user>
                                replied
                                <time class="tooltip" datetime="{{ $conversation->lastPost->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $conversation->lastPost->created_at->format('Y-m-d H:i:s') }}">
                                    {{ $conversation->lastPost->created_at->diffForHumans() }}
                                </time>
                            @else
                                <i class="fa-solid fa-pencil"></i>
                                <discuss-user
                                    :user="{{ json_encode([
                                        'avatar_small'=> $conversation->user->avatar_small,
                                        'profile_url' => $conversation->user->profile_url,
                                        'full_name' => $conversation->user->full_name
                                    ]) }}"
                                    :created-at="{{ var_export($conversation->user->created_at->diffForHumans()) }}"
                                    :last-login="{{ var_export($conversation->user->last_login->diffForHumans()) }}"
                                    :background-color="{{ var_export($conversation->user->avatar_primary_color) }}">
                                </discuss-user>
                                started
                                <time class="tooltip" datetime="{{ $conversation->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $conversation->created_at->format('Y-m-d H:i:s') }}">
                                    {{ $conversation->created_at->diffForHumans() }}
                                </time>
                            @endif
                        </div>

                        <span class="ml-0 md:ml-2 hidden md:inline-block">-</span>

                        {{-- Comments --}}
                        <span class="ml-0 md:ml-2 tooltip" data-tip="This conversation has {{ $conversation->post_count_formated }} comments.">
                            <i class="fa-regular fa-comment"></i>
                            {{ $conversation->post_count_formated }} Comments
                        </span>

                        <!--<span class="ml-0 md:ml-2 hidden md:inline-block">-</span>
                        {{-- Views --}}
                        <span class="ml-0 md:ml-2 tooltip" data-tip="This conversation has 100 views.">
                            <i class="fa-regular fa-eye"></i>
                            100 Views
                        </span>-->

                        {{-- Solved badge --}}
                        @if ($conversation->is_solved)
                            <span class="badge tooltip inline-flex text-white font-semibold border-[color:transparent] gap-2 bg-green-500 ml-0 md:ml-2" data-tip="This conversation is solved.">
                                <i class="fa-solid fa-check"></i>
                                Solved
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Category & Users avatars --}}
                <div class="flex flex-col gap-2 items-center">
                    {{-- Category --}}
                    <a class="badge tooltip inline-flex text-white font-semibold border-[color:transparent] gap-2" href="{{ $conversation->category->category_url }}" data-tip="Category" style="background-color: {{ $conversation->category->color }};">
                        @if (!is_null($conversation->category->icon))
                            <i class="{{ $conversation->category->icon }}"></i>
                        @endif
                        {{ $conversation->category->title }}
                    </a>

                    {{-- Users avatars --}}
                    <div class="avatar-group -space-x-6">
                        {{-- We check if we have at least 2 users (because the first one is the creator) --}}
                        @if($conversation->users()->count() > 1)
                            {{-- Declare the variable used to count the rendered users in the loop --}}
                            @php $user = 0; @endphp

                            @foreach ($conversation->users as $replier)
                                {{-- If the user is the creator of the conversation, continue the loop --}}
                                @if ($replier->getKey() === $conversation->user_id)
                                    @continue
                                @endif

                                {{-- While the user < 2 we display the avatar --}}
                                @if($user < 2)
                                    <div class="avatar border-[color:hsl(var(--b3)/var(--tw-border-opacity))] dark:border-[color:hsl(var(--b1)/var(--tw-border-opacity))]">
                                        <figure class="h-8 w-8">
                                            <img src="{{ $replier->user->avatar_small }}" alt="{{ $replier->user->full_name }} avatar" />
                                        </figure>
                                    </div>
                                @endif

                                {{-- If we have already displayed 2 users, the 3th will be a counter  --}}
                                @if($user == 2)
                                    <div class="avatar placeholder">
                                        <div class="h-8 w-8 bg-neutral-focus text-neutral-content font-semibold">
                                            <span>+{{ $conversation->users()->count() - 3 }}</span>
                                        </div>
                                    </div>
                                    {{-- We break the loop with 2 users and 1 counter --}}
                                    @break
                                @endif

                                {{-- Increment the user --}}
                                @php $user++; @endphp
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </li>
    @empty
        <li class="flex flex-col items-center border border-gray-200 p-3 px-5 rounded dark:bg-base-300 dark:border-gray-700 hover:bg-base-200 dark:hover:bg-base-200 text-gray-400">
            @unless (empty($search))
                <h4 class="text-xl">
                    Whoops !
                </h4>
                <p>
                    There're no result for your search : <b>{{ e($search) }}</b>. Maybe try with another word.
                </p>
            @else
                <h4 class="text-xl mb-2">
                    Whoops !
                </h4>
                <p class="flex flex-col">
                    <span class="mb-5">There's no conversations yet !</span>
                    <a href="{{ route('discuss.conversation.create') }}" class="btn btn-primary gap-2">
                        <i class="fa-solid fa-pencil"></i>
                        Start a Discussion
                    </a>
                </p>
            @endunless
        </li>
    @endforelse
    </ul>

    {{-- Pagination --}}
    <div class="grid grid-cols-1">
        {{ $conversations->links() }}
    </div>
</div>