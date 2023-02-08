<ol class="mb-3">
    <li class="mb-1">
        <a href="{{ route('discuss.index') }}" class="link link-hover hover:text-primary font-xetaravel">
            <i class="fa-regular fa-newspaper text-primary mr-2"></i> All Discussions
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.category.index') }}" class="link link-hover hover:text-primary font-xetaravel">
            <i class="fa-solid fa-list text-primary mr-2"></i> All Categories
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.index', ['f' => 'post_count']) }}" class="link link-hover hover:text-primary font-xetaravel">
            <i class="fa-regular fa-comments text-primary mr-2"></i> Most Commented
        </a>
    </li>
    <li class="mb-1">
        <a href="{{ route('discuss.leaderboard') }}" class="link link-hover hover:text-primary font-xetaravel">
            <i class="fa-regular fa-id-card text-primary mr-2"></i> Leaderboard
        </a>
    </li>
</ol>
<ol class="mb-3">
    @forelse ($categories as $category)
        <li class="mb-1">
            <a href="{{ route('discuss.index', ['c' => $category->getKey()]) }}" class="link link-hover hover:text-primary font-xetaravel flex items-center tooltip" data-tip="{{ $category->description }}">
                <span class="h-4 w-4 rounded inline-block mr-3" style="background-color: {{ $category->color }};"></span>
                @if (!is_null($category->icon))
                    <i class="{{ $category->icon }} mr-1"></i>
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
            <a href="{{ route('discuss.category.index') }}" class="link link-hover hover:text-primary font-xetaravel">
                <span class="h-4 w-4 rounded inline-block mr-3" style="background-color: transparent"></span>
                More...
            </a>
        </li>
    @endif
</ol>