@if($articles->isNotEmpty())
<div class="mb-10">
    <h2 class="mb-4 text-xl font-bold">
        Recent Posts
    </h2>

    @foreach ($articles as $article)
    <div class="flex flex-col bg-base-200 dark:bg-base-300 shadow-md rounded-lg p-6 mb-3">
        <a href="{{ $article->show_url }}" class="text-lg font-medium link link-hover link-primary">
            {{ Str::limit($article->title, 50) }}
        </a>
        <div class="flex justify-between items-center mt-4">
            <div class="flex items-center">
                <a href="{{ $article->user->show_url }}">
                    <img src="{{ $article->user->avatar_small }}" alt="{{ $article->user->full_name }} avatar" class="w-8 h-8 object-cover rounded-full">
                </a>

                <a href="{{ $article->user->show_url }}" class="link link-hover text-sm mx-3">
                    {{ $article->user->full_name }}
                </a>
            </div>
            <span class="font-light text-sm">
                {{ $article->created_at->isoFormat('ll') }}
            </span>
        </div>
    </div>
    @endforeach
</div>
@endif

@if($categories->isNotEmpty())
<div class="mb-10">
    <h2 class="mb-4 text-xl font-bold">
        Categories
    </h2>
    <div class="flex flex-col bg-base-200 dark:bg-base-300 shadow-md rounded-lg p-6 mb-3">
        <ul>
        @foreach ($categories as $category)
            <li class="mb-2">
                <a href="{{ $category->show_url }}" class="font-bold mx-1 link link-hover">
                    - {{ $category->title }} ({{ $category->blog_article_count }})
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endif

@if($users->isNotEmpty())
    <div class="mb-10">
        <h2 class="mb-4 text-xl font-bold">
            Authors
        </h2>
        <div class="flex flex-col bg-base-200 dark:bg-base-300 shadow-md rounded-lg p-6 mb-3">
            <ul>
                @foreach ($users as $user)
                    <li class="flex items-center">
                        <a href="{{ $article->user->show_url }}">
                            <img src="{{ $user->avatar_small }}" alt="{{ $article->user->full_name }} avatar" class="w-10 h-10 object-cover rounded-full mr-4">
                        </a>
                        <p class="flex flex-col items-center">
                            <a href="{{ $article->user->show_url }}" class="font-semibold mx-1 link link-hover truncate">
                                {{ $article->user->full_name }}
                            </a>
                            <span class="text-sm font-light">
                        Created  {{ $article->user->blog_article_count }} Article(s)
                    </span>
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

