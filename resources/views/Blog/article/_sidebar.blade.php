<div class="sidebar-module">
    <h4 class="font-xeta">Latest Articles</h4>
    <ol class="list-unstyled">
        @foreach ($articles as $article)
            <li>
                <a href="{{ route('blog.article.show', ['slug' => $article->slug, 'id' => $article->id]) }}">
                    {{ $article->title }}
                </a>
            </li>
        @endforeach
    </ol>
</div>
<div class="sidebar-module">
    <h4 class="font-xeta">Categories</h4>
    <ol class="list-unstyled">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('blog.category.show', ['slug' => $category->slug, 'id' => $category->id]) }}">
                    {{ $category->title }}
                </a>
                ({{ $category->article_count }})
            </li>
        @endforeach
    </ol>
</div>
