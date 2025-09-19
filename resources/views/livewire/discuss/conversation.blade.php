<div>
    <div class="flex flex-col xl:flex-row xl:justify-between gap-2 mb-5">
        {{-- Categories selection --}}
        <div class="relative flex flex-col sm:flex-row gap-2">
            <x-form.select
                wire:model.live="category"
                :options="$categories"
                option-label="title"
                style="color:{{ $categories[$category]['color'] }}"
                icon="{{ $categories[$category]['icon'] }}" />


            {{-- Order by list --}}
            <div class="flex w-full sm:w-fit">
                <select wire:model.live="sortField" name="sortField" class="select select-bordered w-full sm:w-fit">
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
                <select wire:model.live="limit" name="limit" class="select select-bordered w-full sm:w-fit" title="Limit conversations">
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
                <x-form.input wire:model.live="search" placeholder="Search conversations..." icon="fas-search" />
            </div>
        </div>
    </div>

    <ul class="mb-4">
        @forelse($conversations as $conversation)
            <li class="flex flex-col sm:flex-row p-3 px-5 rounded bg-base-100 dark:bg-base-300 hover:bg-base-300 shadow-md dark:hover:bg-base-200 {{ !$loop->first ? 'mt-3' : '' }}" wire:loading.class.delay="opacity-50">

                <div class="flex flex-row justify-between w-full relative">
                    {{--  Locked & Pinned --}}
                    @if ($conversation->is_pinned === true && $conversation->is_locked === true)
                        <span class="tooltip" data-tip="This conversation is pinned.">
                            <span class="absolute -left-7 -top-2 text-white bg-cyan-400 rounded rounded-r-none rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-cyan-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                                <x-icon name="fas-thumbtack" class="h-[16px] w-[16px]" />
                            </span>
                        </span>
                        <span class="tooltip" data-tip="This conversation is locked.">
                            <span class="absolute -left-1 -top-2 text-white bg-red-400 rounded rounded-l-none color-white font-semibold shadow-md p-1 z-10">
                                <x-icon name="fas-lock" class="h-[16px] w-[16px]" />
                            </span>
                        </span>
                    @elseif($conversation->is_pinned === false && $conversation->is_locked === true)
                        <span class="tooltip" data-tip="This conversation is locked.">
                            <span class="absolute -left-7 -top-2 text-white bg-red-400 rounded rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-red-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                                <x-icon name="fas-lock" class="h-[16px] w-[16px]" />
                            </span>
                        </span>
                    @elseif($conversation->is_pinned === true && $conversation->is_locked === false)
                        <span class="tooltip" data-tip="This conversation is pinned.">
                            <span class="absolute -left-7 -top-2 text-white bg-cyan-400 rounded rounded-tl-none color-white font-semibold shadow-md p-1 before:bg-cyan-400 before:content-[''] before:h-[5px] before:absolute before:left-0 before:top-[-4px] before:w-[10px] before:rounded-tl z-10">
                                <x-icon name="fas-thumbtack" class="h-[16px] w-[16px]" />
                            </span>
                        </span>
                    @endif

                    {{--  User Avatar --}}
                    <div class="hidden sm:flex flex-col">
                        <a class="avatar {{ $conversation->user->online ? 'avatar-online' : 'avatar-offline' }} m-2" href="{{ $conversation->user->show_url }}">
                            <figure class="w-12 h-12 rounded-full ring-2 ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $conversation->user->username }} is {{ $conversation->user->online ? 'online' : 'offline' }}">
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
                            <div class="sm:flex items-center gap-1">
                                @if ($conversation->first_post_id !== $conversation->last_post_id)
                                    <x-icon name="fas-reply" class="h-4 w-4 inline" />
                                    <x-user.user
                                        :user-name="$conversation->lastPost->user->full_name"
                                        :user-avatar-small="$conversation->lastPost->user->avatar_small"
                                        :user-profile="$conversation->lastPost->user->show_url"
                                        :user-last-login="$conversation->lastPost->user->last_login_date->diffForHumans()"
                                        :user-registered="$conversation->lastPost->user->created_at->diffForHumans()"
                                    />
                                    replied
                                    <time class="tooltip" datetime="{{ $conversation->lastPost->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $conversation->lastPost->created_at->format('Y-m-d H:i:s') }}">
                                        {{ $conversation->lastPost->created_at->diffForHumans() }}
                                    </time>
                                @else
                                    <x-icon name="fas-pencil" class="h-4 w-4 inline" />
                                    <x-user.user
                                        :user-name="$conversation->user->full_name"
                                        :user-avatar-small="$conversation->user->avatar_small"
                                        :user-profile="$conversation->user->show_url"
                                        :user-last-login="$conversation->user->last_login_date->diffForHumans()"
                                        :user-registered="$conversation->user->created_at->diffForHumans()"
                                    />
                                    started
                                    <time class="tooltip" datetime="{{ $conversation->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $conversation->created_at->format('Y-m-d H:i:s') }}">
                                        {{ $conversation->created_at->diffForHumans() }}
                                    </time>
                                @endif
                            </div>

                            <span class="ml-0 md:ml-2 hidden md:inline-block">-</span>

                            {{-- Comments --}}
                            <span class="ml-0 md:ml-2 tooltip" data-tip="This conversation has {{ $conversation->post_count_formated }} comments.">
                                    <x-icon name="far-comment" class="h-4 w-4 inline" />
                                {{ $conversation->post_count_formated }} Comment(s)
                            </span>

                            {{-- Views --}}
                            {{-- <span class="ml-0 md:ml-2 hidden md:inline-block">-</span>

                            <span class="ml-0 md:ml-2 tooltip" data-tip="This conversation has 100 views.">
                                <x-icon name="far-eye" class="h-4 w-4 inline" />
                                100 Views
                            </span>--}}

                            {{-- Solved badge --}}
                            @if ($conversation->is_solved)
                                <span class="badge tooltip inline-flex text-white font-semibold gap-2 bg-green-500 ml-0 md:ml-2" data-tip="This conversation is solved.">
                                <x-icon name="fas-check" class="h-4 w-4 inline" />
                                Solved
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Category & Users avatars --}}
                    <div class="flex flex-col gap-2 items-center">
                        {{-- Category --}}
                        <a class="badge tooltip inline-flex text-white font-semibold gap-2" href="{{ $conversation->category->show_url }}" data-tip="Category" style="background-color: {{ $conversation->category->color }};">
                            @if (!is_null($conversation->category->icon))
                                <x-icon name="{{ $conversation->category->icon }}" class="h-3 w-3 inline" />
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
                                        <div class="avatar border-[color:var(--color-base-300)] dark:border-[color:var(--color-base-100)]">
                                            <figure class="h-8 w-8">
                                                <img src="{{ $replier->user->avatar_small }}" alt="{{ $replier->user->full_name }} avatar" />
                                            </figure>
                                        </div>
                                    @endif

                                    {{-- If we have already displayed 2 users, the 3th will be a counter  --}}
                                    @if($user == 2)
                                        <div class="avatar avatar-placeholder">
                                            <div class="h-8 w-8 bg-neutral text-neutral-content font-semibold">
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
            <li class="flex flex-col items-center border border-gray-200 p-3 px-5 rounded dark:bg-base-300 dark:border-gray-700 hover:bg-base-200 dark:hover:bg-base-200">
                @unless (empty($search))
                    <h4 class="text-xl">
                        Whoops !
                    </h4>
                    <p>
                        There are no result for your search : <b>{{ e($search) }}</b>. Maybe try with another word.
                    </p>
                @else
                    <h4 class="text-xl mb-2">
                        Whoops !
                    </h4>
                    <p class="flex flex-col">
                        <span class="mb-5">There's no conversations yet !</span>
                        @can('create', \Xetaravel\Models\DiscussConversation::class)
                            <x-button icon="fas-pencil" label="Start a Discussion" class="btn-primary gap-2 conversationCreateButton" />
                        @endcan
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
