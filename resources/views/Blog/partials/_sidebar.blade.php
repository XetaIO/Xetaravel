<div class="sidebar-module">
    <h2 class="sidebar-module-title font-xeta">
        Latest Articles
    </h2>
    <ol class="list-unstyled">
        @foreach ($articles as $article)
            <li>
                <a href="{{ $article->article_url }}">
                    {{ $article->title }}
                </a>
            </li>
        @endforeach
    </ol>
</div>
<div class="sidebar-module">
    <h2 class="sidebar-module-title font-xeta">
        Categories
    </h2>
    <ol class="list-unstyled">
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->category_url }}">
                    {{ $category->title }}
                </a>
                ({{ $category->article_count }})
            </li>
        @endforeach
    </ol>
</div>
