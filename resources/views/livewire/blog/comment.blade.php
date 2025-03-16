{{-- Comments --}}
<section class="bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-10">
    <h2 class="divider text-xl font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>
        {{ $article->blog_comment_count }} Comment(s)
    </h2>

    @forelse ($comments as $comment)
        @include('Blog::partials._comment', ['comment' => $comment])
    @empty
        <div class="alert alert-info shadow-lg mb-5">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>
                    There are no comments yet, post the first reply !
                </span>
            </div>
        </div>
    @endforelse

    {{-- Coments pagination --}}
    <div class="grid grid-cols-1">
        {{ $comments->links() }}
    </div>

    {{--  Reply --}}
    @auth
        <div class="divider text-lg font-bold">
            <x-icon name="fas-reply" class="h-11 w-11" />
            Reply
        </div>

        <div class="flex flex-col sm:flex-row items-center">
            <div class="self-start mx-auto">
                {{--  User Avatar --}}
                <a class="avatar avatar-online m-2" href="{{ Auth::user()->profile_url }}">
                    <figure class="w-16 h-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="Connected as {{ Auth::user()->username }}">
                        <img class="rounded-full" src="{{ Auth::user()->avatar_small }}"  alt="{{ Auth::user()->full_name }} avatar" />
                    </figure>
                </a>
            </div>

            {{-- Editor --}}
            <div class="self-start ml-3 mt-3 w-full">

                <x-form method="post" action="{{ route('blog.comment.create') }}">
                    <x-input type="hidden" class="hidden" name="article_id" value="{{ $article->id }}" />
                    <x-markdown wire:model="content" label="Comment" placeholder="Your message here..." />

                    <x-button  type="submit" icon-right="fas-pencil" icon-classes="h-4 w-4" label="Comment" class="btn-primary gap-2" />
                </x-form>
            </div>
        </div>
    @else
        <x-alert type="primary" class="mt-5">
            You need to be logged in to comment to this article !
        </x-alert>
    @endif
</section>
