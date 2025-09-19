<x-layouts.app>
    <x-slot:title>
        All Categories
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="All Categories" />
    </x-slot:meta>

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="lg:container mx-auto pt-4 mb-5">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-3 col-span-12 px-3">
                @include('Discuss::partials._sidebar')
            </div>

            <div class="lg:col-span-9 col-span-12 px-3">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    @forelse ($categories as $category)
                        <div class="lg:col-span-4 col-span-12">
                            <div class="flex flex-col justify-between p-2 rounded-md shadow-md text-white h-full" style="background-color: {{ $category->color }};">
                                <div class="mb-3">
                                    <h5 class="text-2xl text-center mb-2">
                                        <a class="" href="{{ $category->show_url }}">
                                            {{ $category->title }}
                                        </a>
                                    </h5>
                                    <div class="text-sm">
                                        {{ $category->description }}
                                    </div>
                                </div>

                                <div class="truncate">
                                @if (!is_null($category->lastConversation))
                                    <a  class="" href="{{ route('discuss.post.show', ['id' => $category->lastConversation->last_post_id]) }}">
                                        <strong>{{ $category->lastConversation->title }}</strong>

                                        <time datetime="{{ $category->lastConversation->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $category->lastConversation->created_at->diffForHumans() }}
                                        </time>
                                    </a>
                                @else
                                    There's no conversation yet.
                                @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <x-alert type="primary">
                                There's no categories yet.
                            </x-alert>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
