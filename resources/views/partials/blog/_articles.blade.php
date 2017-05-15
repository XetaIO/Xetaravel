@forelse ($articles as $article)
    <div class="blog-post">
        <h1 class="blog-title">
            <a href="{{ route('blog.article.show', ['slug' => $article->slug, 'id' => $article->id]) }}">
                {{ str_limit($article->title, 150) }}
            </a>
        </h1>
        <div class="blog-post-meta">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <i class="fa fa-calendar" aria-hidden="true"></i> {{ $article->created_at }}
                </li>
                <li class="list-inline-item">
                    By
                    <a href="{{ route('users.user.show', ['slug' => $article->user->slug, 'id' => $article->user->id]) }}">
                        {{ $article->user->username }}
                    </a>
                </li>
            </ul>
        </div>

        {!! Purifier::clean(
            str_limit($article->content, 650),
            'blog_article_empty'
        ) !!}

        <div class="blog-footer">
            <a href="{{ route('blog.article.show', ['slug' => $article->slug, 'id' => $article->id]) }}" class="btn btn-outline-primary">
                Read More
            </a>
        </div>
    </div>
    <hr />
@empty
    <div class="alert alert-primary" role="alert">
        <i class="fa fa-exclamation" aria-hidden="true"></i>
        There's no article yet, come back later !
    </div>
@endforelse

<div class="col-md 12 text-xs-center">
    {{ $articles->render() }}
</div>
