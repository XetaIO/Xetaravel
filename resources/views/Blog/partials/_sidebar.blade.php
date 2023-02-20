@if($articles->isNotEmpty())
<div class="mb-10">
    <h2 class="mb-4 text-xl font-bold">
        Recent Posts
    </h2>

    @foreach ($articles as $article)
    <div class="flex flex-col bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-3">
        <div class="flex justify-center items-center">
            <a class="badge badge-outline badge-lg tooltip inline-flex" href="{{ $article->category->category_url }}" data-tip="Category">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
                {{ $article->category->title }}
            </a>
        </div>
        <div class="mt-4">
            <a href="{{ $article->article_url }}" class="text-lg font-medium link link-hover dark:text-primary">
                {{ Str::limit($article->title, 50) }}
            </a>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div class="flex items-center">
                <a href="{{ $article->user->profile_url }}">
                    <img src="{{ $article->user->avatar_small }}" alt="{{ $article->user->full_name }} avatar" class="w-8 h-8 object-cover rounded-full">
                </a>

                <a href="{{ $article->user->profile_url }}" class="link link-hover text-sm mx-3">
                    {{ $article->user->full_name }}
                </a>
            </div>
            <span class="font-light text-sm">
                {{ $article->created_at->formatLocalized('%b %d, %Y') }}
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
    <div class="flex flex-col bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-3">
        <ul>
        @foreach ($categories as $category)
            <li class="mb-2">
                <a href="{{ $category->category_url }}" class="font-bold mx-1 link link-hover">
                    - {{ $category->title }} ({{ $category->article_count }})
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endif

<div class="mb-10">
    <h2 class="mb-4 text-xl font-bold">
        Authors
    </h2>
    <div class="flex flex-col bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-3">
        <ul>
            @foreach ($users as $user)
            <li class="flex items-center">
                <a href="{{ $article->user->profile_url }}">
                    <img src="{{ $user->avatar_small }}" alt="{{ $article->user->full_name }} avatar" class="w-10 h-10 object-cover rounded-full mr-4">
                </a>
                <p class="flex flex-col items-center">
                    <a href="{{ $article->user->profile_url }}" class="font-semibold mx-1 link link-hover truncate">
                        {{ $article->user->full_name }}
                    </a>
                    <span class="text-sm font-light">
                        Created  {{ $article->user->article_count }} Post(s)
                    </span>
                </p>
            </li>
            @endforeach
        </ul>
    </div>
</div>
