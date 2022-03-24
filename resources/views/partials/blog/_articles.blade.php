@forelse ($articles as $article)
    <div class="blog-post">
        <h1 class="blog-title">
            <a href="{{ $article->article_url }}">
                {{ Str::limit($article->title, 150) }}
            </a>
        </h1>
        <div class="blog-post-meta">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <time datetime="{{ $article->created_at->format('Y-m-d H:i:s') }}" title="{{ $article->created_at->format('Y-m-d H:i:s') }}" data-toggle="tooltip">
                        {{ $article->created_at->format('Y-m-d') }}
                    </time>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-user"></i>
                    <a href="{{ $article->user->profile_url }}">
                        {{ $article->user->username }}
                    </a>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-comments"></i>
                    {{ $article->comment_count }}
                </li>
            </ul>
        </div>

        <div>
            {!! Markdown::convertToHtml(Str::limit($article->content, 650)) !!}
        </div>

        <div class="blog-footer">
            <a href="{{ $article->article_url }}" class="btn btn-outline-primary">
                <i aria-hidden="true" class="fa fa-newspaper-o"></i> Read More
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
