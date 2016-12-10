<div class="sidebar-module">
    <h4>Latest Articles</h4>
    <ol class="list-unstyled">
        @foreach ($articles as $article)
            <li>
                <a href="{{ route('blog_article_show', ['slug' => $article->slug, 'id' => $article->id]) }}">
                    {{ $article->title }}
                </a>
            </li>
        @endforeach
    </ol>
</div>
<div class="sidebar-module">
    <h4>Categories</h4>
    <ol class="list-unstyled">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('blog_category_show', ['slug' => $category->slug, 'id' => $category->id]) }}">
                    {{ $category->title }}
                </a>
                ({{ $category->article_count }})
            </li>
        @endforeach
    </ol>
</div>
