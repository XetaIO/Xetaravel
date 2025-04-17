{{-- Comments --}}
<section id="paginated-comments" class="bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-6 mb-10">
    <h2 class="divider text-xl font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>
        {{ $blogCommentCount }} Comment(s)
    </h2>

    @forelse ($comments as $comment)
        @include('Blog::partials._comment', ['comment' => $comment, 'article' => $article])
    @empty
        <x-alert type="info">
            There are no comments yet, post the first reply !
        </x-alert>
    @endforelse

    {{-- Comments pagination --}}
    <div class="grid grid-cols-1">
        {{ $comments->links(data: ['scrollTo' => '#paginated-comments']) }}
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
                <a class="avatar avatar-online m-2" href="{{ Auth::user()->show_url }}">
                    <figure class="w-16 h-16 rounded-full ring-2 ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="Connected as {{ Auth::user()->username }}">
                        <img class="rounded-full" src="{{ Auth::user()->avatar_small }}"  alt="{{ Auth::user()->full_name }} avatar" />
                    </figure>
                </a>
            </div>

            {{-- Editor --}}
            <div class="self-start ml-3 mt-3 w-full">
                <x-markdown wire:model="form.content" name="form.content" label="Comment" placeholder="Your message here..." />

                <x-button wire:click="create" icon="fas-pencil" label="Comment" class="btn-primary gap-2" spinner />
            </div>
        </div>
    @else
        <x-alert type="primary" class="mt-5">
            You need to be logged in to comment to this article !
        </x-alert>
    @endif

    @auth
        {{-- Delete BlogComment Modal --}}
        <x-modal wire:model="deleteCommentModal" title="Delete the comment">
            <x-form no-separator>
                <p>
                    Are you sure you want delete this comment ? <strong>This operation is not reversible.</strong>
                </p>

                <x-slot:actions>
                    <x-button label="Yes, I confirm !" class="btn-primary" icon="fas-trash-alt" wire:click="delete()" spinner />
                    <x-button label="Cancel" @click="$wire.deleteCommentModal = false" />
                </x-slot:actions>
            </x-form>
        </x-modal>
    @endauth
</section>
