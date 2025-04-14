<ol class="mb-3">
    <li class="mb-1">
        <a href="{{ route('discuss.index') }}" class="link link-hover hover:text-primary">
            <x-icon name="far-newspaper" class="h-4 w-4 inline text-primary mr-2" />
            All Discussions
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.category.index') }}" class="link link-hover hover:text-primary">
            <x-icon name="fas-list" class="h-4 w-4 inline text-primary mr-2" />
            All Categories
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.index', ['f' => 'post_count']) }}" class="link link-hover hover:text-primary">
            <x-icon name="far-comments" class="h-4 w-4 inline text-primary mr-2" />
            Most Commented
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.leaderboard') }}" class="link link-hover hover:text-primary">
            <x-icon name="far-id-card" class="h-4 w-4 inline text-primary mr-2" />
            Leaderboard
        </a>
    </li>
</ol>
<ol class="mb-3">
    @forelse ($categories as $category)
        <li class="mb-1">
            <a href="{{ $category->show_url }}" class="link link-hover hover:text-primary flex items-center tooltip" data-tip="{{ $category->description }}">
                <span class="h-4 w-4 rounded inline-block mr-3" style="background-color: {{ $category->color }};"></span>
                @if (!is_null($category->icon))
                    <x-icon name="{{ $category->icon }}" class="h-4 w-4 inline mr-1" />
                @endif
                {{ $category->title }}
            </a>
        </li>
    @empty
        <li class="mb-1">
            There's no categories yet.
        </li>
    @endforelse

    @if ($categories->count() >= config('xetaravel.discuss.categories_sidebar'))
        <li class="mb-1">
            <a href="{{ route('discuss.category.index') }}" class="link link-hover hover:text-primary">
                <span class="h-4 w-4 rounded inline-block mr-3" style="background-color: transparent"></span>
                More...
            </a>
        </li>
    @endif
</ol>
