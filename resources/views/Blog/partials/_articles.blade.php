@forelse ($articles as $article)
<article class="md:max-w-none grid lg:grid-cols-2 gap-6 md:gap-8 lg:gap-12 xl:gap-16 items-center bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-3 mb-10">
    <a class="relative block group" href="{{ $article->article_url }}">
        <div class="absolute inset-0 bg-gray-600 dark:bg-gray-700 hidden lg:block transform lg:translate-y-2 md:translate-x-4 xl:translate-y-4 xl:translate-x-8 group-hover:translate-x-0 group-hover:translate-y-0 transition duration-700 ease-out pointer-events-none" aria-hidden="true"></div>
        <figure class="relative h-0 pb-[56.25%] overflow-hidden transform lg:-translate-y-2 xl:-translate-y-4 group-hover:translate-x-0 group-hover:translate-y-0 transition duration-700 ease-out">
            <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="{{ $article->article_banner }}" width="540" height="303" alt="Blog post">
        </figure>
    </a>
    <div>
        <header>
            <div class="mb-1">
                <ul class="flex flex-wrap">
                    <li class="m-1">
                        <a class="badge badge-outline badge-lg tooltip inline-flex" href="{{ $article->category->category_url }}" data-tip="Category">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            {{ $article->category->title }}
                        </a>
                    </li>
                </ul>
            </div>
            <h3 class="text-2xl lg:text-3xl font-bold leading-tight mb-2">
                <a class="link link-hover dark:text-primary" href="{{ $article->article_url }}">
                    {{ Str::limit($article->title, 150) }}
                </a>
            </h3>
        </header>

        <div>
            {!! Markdown::convert(Str::limit($article->content, 550)) !!}
        </div>

        <footer class="flex items-center mt-4">
            <a href="{{ $article->user->profile_url }}">
                <img class="w-12 h-12 rounded-full flex-shrink-0 mr-3" src="{{ $article->user->avatar_small }}" alt="{{ $article->user->full_name }} avatar">
            </a>
            <div>
                    <discuss-user
                        :user="{{ json_encode([
                            'avatar_small'=> $article->user->avatar_small,
                            'profile_url' => $article->user->profile_url,
                            'full_name' => $article->user->full_name
                        ]) }}"
                        :created-at="{{ var_export($article->user->created_at->diffForHumans()) }}"
                        :last-login="{{ var_export($article->user->last_login->diffForHumans()) }}"
                        :background-color="{{ var_export($article->user->avatar_primary_color) }}">
                    </discuss-user>
                <span class="text-gray-700"> - </span>
                <span class="text-gray-500">
                    <time datetime="{{ $article->created_at }}" class="tooltip" data-tip="{{ $article->created_at }}">
                        {{ $article->created_at->diffForHumans() }}
                    </time>
                </span>
                <span class="text-gray-700"> - </span>
                <span class="text-gray-500 font-semibold tooltip" data-tip="Comments">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block  align-text-top">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>

                    {{ $article->comment_count }}
                </span>
            </div>
        </footer>
    </div>
</article>
@empty
<div class="alert alert-error shadow-lg mb-5">
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <div>
            <h3 class="font-bold">Whoops</h3>
            <div class="text-xs">There's no article yet, come back later !</div>
        </div>
    </div>
    <div class="flex-none">
        <a class="btn btn-sm" href="{{ route('page.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Visit Home
        </a>
    </div>
</div>
@endforelse

<div class="grid grid-cols-1">
    {{ $articles->links() }}
</div>
