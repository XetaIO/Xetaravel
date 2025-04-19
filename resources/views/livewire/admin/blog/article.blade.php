<div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                {{-- Search input --}}
                <div class="w-full lg:w-auto md:min-w-[300px]">
                    <x-input icon="fas-search" wire:model.live.debounce="search" placeholder="Search Articles..." class="lg:max-w-lg" />
                </div>
                {{-- Create/Delete buttons --}}
                <div class="flex flex-col md:flex-row gap-2">
                    @if($selected?->isNotEmpty())
                        <x-button icon="fas-trash" type="button" label="Delete Article(s)" class="btn btn-error" wire:click="deleteSelected" spinner />
                    @endif
                    @can('create', \Xetaravel\Models\BlogArticle::class)
                            <x-button icon="fas-plus" type="button" label="New Article" class="btn btn-success articleCreateButton" spinner />
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md  rounded-lg p-3">
            <x-table.table class="mb-6">
                <x-slot name="head">
                    <x-table.heading>
                        <label>
                            <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                        </label>
                    </x-table.heading>
                    <x-table.heading>Actions</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">Id</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Author</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('blog_category_id')" :direction="$sortField === 'blog_category_id' ? $sortDirection : null">Category</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('blog_comment_count')" :direction="$sortField === 'blog_comment_count' ? $sortDirection : null">Comment(s)</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('published_at')" :direction="$sortField === 'published_at' ? $sortDirection : null">Published at</x-table.heading>
                    <x-table.heading>Is display</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created at</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row wire:key="row-message">
                            <x-table.cell colspan="10">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $articles->count() }}</strong> article(s), do you want to select all <strong>{{ $articles->total() }}</strong> article(s)?</span>
                                        <x-button type="button" icon="fas-check" label="Tout sélectionner" wire:click='setSelectAll' class="btn-sm" spinner />
                                    </div>
                                @else
                                    <span>You have selected actually <strong>{{ $articles->total() }}</strong> article(s).</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($articles as $article)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $article->getKey() }}">
                            @can('delete', $article)
                                <x-table.cell>
                                    <label>
                                        <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $article->getKey() }}" />
                                    </label>
                                </x-table.cell>
                            @endcan
                            @can('update', $article)
                                <x-table.cell>
                                    <x-button icon="fas-pen-to-square" data-content="{{ $article->getKey() }}" class="articleUpdateButton btn-ghost tooltip tooltip-right" data-tip="Edit this article" />
                                </x-table.cell>
                            @endcan
                            <x-table.cell>
                                {{ $article->getKey() }}
                            </x-table.cell>
                            <x-table.cell>
                                <a class="link link-hover link-primary font-bold" href="{{ $article->show_url }}">
                                    {{ $article->title }}
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a class="link link-hover link-primary font-bold" href="{{ $article->user->show_url }}">
                                    {{ $article->user->full_name }}
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a class="link link-hover link-primary font-bold" href="{{ $article->category->show_url }}">
                                    {{ $article->category->title }}
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $article->blog_comment_count }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $article->published_at?->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                            <x-table.cell>
                                @if ($article->is_display)
                                    <span class="font-bold text-green-500">
                                        Yes
                                    </span>
                                @else
                                    <span class="font-bold text-red-500">
                                        No
                                    </span>
                                @endif
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $article->created_at->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="8">
                                <div class="text-center p-2">
                                    <span class="text-muted">No articles found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="grid grid-cols-1">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
