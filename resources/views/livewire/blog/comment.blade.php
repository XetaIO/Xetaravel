{{-- Comments --}}
<section id="paginated-comments" class="bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-6 mb-10">
    <h2 class="divider text-xl font-bold">
        <x-icon name="far-comments" class="w-16 h-16" />
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
                <x-form.markdown wire:model="form.content" name="form.content" label="Comment" placeholder="Your message here..." />

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
            <x-form.form no-separator>
                <p>
                    Are you sure you want delete this comment ? <strong>This operation is not reversible.</strong>
                </p>

                <x-slot:actions>
                    <x-button label="Yes, I confirm !" class="btn-primary" icon="fas-trash-alt" wire:click="delete()" spinner />
                    <x-button label="Cancel" @click="$wire.deleteCommentModal = false" />
                </x-slot:actions>
            </x-form.form>
        </x-modal>
    @endauth
</section>
