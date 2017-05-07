@extends('layouts.app')
{!! config(['app.title' => 'Category : ' . $category->title]) !!}

@section('content')
<div class="container pb-1">
    <div class="blog-header mt-2">
        <div class="container">
            <h1 class="blog-title">
                {{ $category->title }}
            </h1>
            <p class="lead blog-description text-muted">
                {{ $category->description }}
            </p>
        </div>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">
        <div class="col-md-9">
            @if (!empty($articles->toArray()['data']))
                @foreach ($articles as $article)
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
                @endforeach

                <div class="col-md 12 text-xs-center">
                    {{ $articles->render() }}
                </div>
            @endif
        </div>

        <div class="col-md-3">
            @include('Blog::article._sidebar')
        </div>

    </div>
</div>
@endsection
