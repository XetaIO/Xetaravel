<div class="sidebar-module">
    <h4 class="font-xeta">
        Latest Articles
    </h4>
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
    <h4 class="font-xeta">
        Categories
    </h4>
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
