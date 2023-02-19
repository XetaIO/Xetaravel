<div>
    @push('scripts')
        <script type="text/javascript">
            Livewire.on('alert', () => {
                document.querySelectorAll('[data-dismiss-target]').forEach(triggerEl => {
                    const targetEl = document.querySelector(triggerEl.getAttribute('data-dismiss-target'))

                    new Dismiss(targetEl, {
                        triggerEl
                    })
                });
            });
        </script>
    @endpush
    @include('elements.flash')

    <div class="flex flex-col lg:flex-row gap-6 justify-between">
        <div class="mb-4 w-full lg:w-auto lg:min-w-[350px]">
            <x-form.text wire:model="search" placeholder="Search Articles..." class="lg:max-w-lg" />
        </div>
        <div class="mb-4">
            <div class="dropdown lg:dropdown-end">
            <label tabindex="0" class="btn m-1">
                Bulk Actions
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                        <i class="fa-solid fa-trash-can"></i> Delete
                    </button>
                </li>
            </ul>
        </div>
            <a href="{{ route('admin.blog.article.create') }}" class="btn gap-2">
                <i class="fa-solid fa-plus"></i>
                New Article
            </a>
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            <x-table.heading>
                <label>
                    <input type="checkbox" class="checkbox" wire:model="selectPage" />
                </label>
            </x-table.heading>
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('category_id')" :direction="$sortField === 'category_id' ? $sortDirection : null">Category</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('comment_count')" :direction="$sortField === 'comment_count' ? $sortDirection : null">Comments</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_display')" :direction="$sortField === 'is_display' ? $sortDirection : null">Dislayed</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
            <x-table.row class="bg-cool-gray-200" wire:key="row-message" >
                <x-table.cell colspan="8">
                    @unless ($selectAll)
                    <div>
                        <span>You have selected <strong>{{ $articles->count() }}</strong> articles, do you want to select all <strong>{{ $articles->count() }}</strong>?</span>
                        <button type="button" wire:click="selectAll" class="btn btn-sm gap-2 ml-1">
                            <i class="fa-solid fa-check"></i>
                            Select All
                        </button>
                    </div>
                    @else
                    <span>You are currently selecting all <strong>{{ $articles->total() }}</strong> articles.</span>
                    @endif
                </x-table.cell>
            </x-table.row>
            @endif

            @forelse($articles as $article)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $article->getKey() }}">
                    <x-table.cell>
                        <label>
                            <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $article->getKey() }}" />
                        </label>
                    </x-table.cell>
                    <x-table.cell>{{ $article->getKey() }}</x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary" href="{{ $article->article_url }}">
                            {{ $article->title }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary" href="{{ $article->category->category_url }}">
                            {{ $article->category->title }}
                        </a>
                        </x-table.cell>
                    <x-table.cell>{{ $article->comment_count }}</x-table.cell>
                    <x-table.cell>
                        @if ($article->is_display)
                            <span class="font-bold text-green-500">Yes</span>
                        @else
                            <span class="font-bold text-red-500">No</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>{{ $article->created_at->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>
                        <a href="{{ route('admin.blog.article.edit', ['slug' => $article->slug, 'id' => $article->id]) }}" class="tooltip" data-tip="Edit this article">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
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


    <!-- Delete Articles Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Delete Articles
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        You have not selected any article to delete.
                    </p>
                @else
                    <p class="my-7">
                        Are you sure you want to delete those Articles ? <span class="font-bold text-red-500">This operation is not reversible.</span>
                    </p>
                @endif
                <div class="modal-action">
                    <button type="submit" class="btn btn-error gap-2" @if (empty($selected)) disabled @endif>
                        <i class="fa-solid fa-trash-can"></i>
                        Delete
                    </button>
                    <label for="deleteModal" class="btn">Close</label>
                </div>
            </label>
        </label>
    </form>

</div>
