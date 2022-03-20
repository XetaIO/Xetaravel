<ol class="list-unstyled discuss-categories">
    <li>
        <a href="{{ route('discuss.index') }}" class="discuss-categories-link font-xeta">
            <i class="fa fa-newspaper-o text-primary"></i> All Discussions
        </a>
    </li>
    <li>
        <a href="{{ route('discuss.category.index') }}" class="discuss-categories-link font-xeta">
            <i class="far fa-list-alt text-primary"></i> All Categories
        </a>
    </li>
    <!-- <li>
        <a href="#" class="discuss-categories-link">
            <i class="fa fa-comments-o text-primary"></i> Most Commented
        </a>
    </li> -->
    <li>
        <a href="{{ route('discuss.leaderboard') }}" class="discuss-categories-link font-xeta">
            <i class="far fa-id-card text-primary"></i> Leaderboard
        </a>
    </li>
</ol>
<ol class="list-unstyled discuss-categories">
    @forelse ($categories as $category)
        <li>
            <a href="{{ $category->category_url }}" class="discuss-categories-link font-xeta" data-toggle="tooltip" title="{{ $category->description }}">
                <span class="discuss-categories-color" style="background-color: {{ $category->color }};"></span>
                @if (!is_null($category->icon))
                    <i class="{{ $category->icon }} discuss-categories-icon"></i>
                @endif
                {{ $category->title }}
            </a>
        </li>
    @empty
        <li>
            There's no categories yet.
        </li>
    @endforelse

    @if ($categories->count() >= config('xetaravel.discuss.categories_sidebar'))
        <li>
            <a href="{{ route('discuss.category.index') }}" class="discuss-categories-link font-xeta">
                <span class="discuss-categories-color" style="background-color: transparent"></span>
                More...
            </a>
        </li>
    @endif
</ol>