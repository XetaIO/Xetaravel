@forelse ($articles as $article)
    <div class="blog-post">
        <h1 class="blog-post-title">
            <a href="{{ $article->article_url }}">
                {{ Str::limit($article->title, 150) }}
            </a>
        </h1>
        <div class="blog-post-meta">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <time datetime="{{ $article->created_at }}" title="{{ $article->created_at }}" data-toggle="tooltip">
                        {{ $article->created_at->diffForHumans() }}
                    </time>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-user"></i>
                    <discuss-user
                        :user="{{ json_encode($article->user) }}"
                        :created-at="{{ var_export($article->user->created_at->diffForHumans()) }}"
                        :last-login="{{ var_export($article->user->last_login->diffForHumans()) }}"
                        :background-color="{{ var_export($article->user->avatar_primary_color) }}">
                    </discuss-user>
                </li>
                <li class="list-inline-item">
                    <i class="fa fa-comments"></i>
                    {{ $article->comment_count }}
                </li>
            </ul>
        </div>

        <img class="blog-post-banner mb-1" src="{{ $article->article_banner }}" alt="Article image">

        <div class="blog-post-content">
            {!! Markdown::convertToHtml(Str::limit($article->content, 650)) !!}
        </div>

        <div class="blog-footer">
            <a href="{{ $article->article_url }}" class="btn btn-outline-primary">
                <i aria-hidden="true" class="fa fa-newspaper-o"></i> Read More
            </a>
        </div>
    </div>
@empty
    <div class="alert alert-primary" role="alert">
        <i class="fa fa-exclamation" aria-hidden="true"></i>
        There's no article yet, come back later !
    </div>
@endforelse

<div class="col-md 12 text-xs-center">
    {{ $articles->render() }}
</div>
