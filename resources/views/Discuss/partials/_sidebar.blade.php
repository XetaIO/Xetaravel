<ol class="list-unstyled discuss-categories">
    <li>
        <a href="{{ route('discuss.index') }}" class="discuss-categories-link font-xeta">
            <i class="fa fa-newspaper-o text-primary"></i> All Discussions
        </a>
    </li>
    <li>
        <a href="#" class="discuss-categories-link font-xeta">
            <i class="fa fa-comments-o text-primary"></i> Most Commented
        </a>
    </li>
</ol>
<ol class="list-unstyled discuss-categories">
    @forelse ($categories as $category)
        <li>
            <a href="{{ $category->category_url }}" class="discuss-categories-link font-xeta">
                <span class="discuss-categories-color" style="background-color: {{ $category->color }};"></span>
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