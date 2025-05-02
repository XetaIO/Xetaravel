@extends('layouts.app')
{!! config(['app.title' => $article->title]) !!}

@push('meta')
    <x-meta
        title="{{ $article->title }}"
        author="{{ $article->user->username }}"
        description="{!! Markdown::convert($article->content) !!}"
        url="{{ $article->show_url }}"
    />
@endpush

@push('scriptsTop')
    @vite('resources/js/highlight.js')
    @vite('resources/js/easymde.js')

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // HighlightJS
            hljs.highlightAll();
        });
    </script>
@endpush

@section('content')
<!-- Breadcrumbs -->
<section class="lg:container mx-auto mt-12 mb-5  overflow-hidden">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<!-- BlogArticle -->
<section class="lg:container mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-9 col-span-12 px-3">

            {{-- BlogArticle --}}
            <article class="bg-base-100 dark:bg-base-300 shadow-md rounded-lg pb-6 mb-10">

                {{-- BlogArticle Header --}}
                <header class="mb-6">
                    <div class="relative mb-8">
                        {{-- BlogArticle Banner --}}
                        <figure class="overlay after:rounded-t-lg">
                            <img class="object-cover rounded-t-lg w-full" src="{{ $article->article_banner }}" alt="Article image">
                        </figure>

                        {{-- Author avatar --}}
                        <a class="absolute -bottom-6 left-6 tooltip" href="{{ $article->user->show_url }}" data-tip="{{ $article->user->full_name }}">
                            <img class="w-12 h-12 rounded-full ring-2 ring-primary" src="{{ asset($article->user->avatar_small) }}" alt="{{ $article->user->username }} Avatar">
                        </a>
                    </div>

                    {{-- BlogArticle meta --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mt-2 px-6">
                        <div class="flex justify-center items-center">
                            <time class="tooltip" datetime="{{ $article->created_at->format('Y-m-d H:i:s') }}" data-tip="{{ $article->created_at->format('Y-m-d H:i:s') }}">
                                {{ $article->created_at->isoFormat('ll') }}
                            </time>
                            <span class="text-gray-700 mx-2"> - </span>
                            <span class="font-semibold tooltip" data-tip="Comments">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                </svg>
                                {{ $article->blog_comment_count }}
                            </span>

                            <span class="text-gray-700 mx-2"> - </span>

                            {{-- Share links --}}
                            <div class="flex gap-2">
                                <span class="hidden md:block">Share this Post : </span>
                                <a href="{{ $shareLinks['facebook'] }}" target="_blank" class="link">
                                    <x-icon name="fab-square-facebook" class="h-6 w-6 text-blue-600" />
                                </a>
                                <a href="{{ $shareLinks['twitter'] }}" target="_blank" class="link">
                                    <x-icon name="fab-square-twitter" class="h-6 w-6 text-sky-400" />
                                </a>
                                <a href="{{ $shareLinks['linkedin'] }}" target="_blank" class="link">
                                    <x-icon name="fab-linkedin" class="h-6 w-6 text-blue-800" />
                                </a>
                            </div>

                            {{-- Edit button --}}
                            @can('update', $article)
                                <span class="text-gray-700 mx-2"> - </span>
                                <x-button link="{{ route('admin.blog.article.index') }}" icon="fas-pencil" label="Edit" class="btn-sm gap-2" />
                            @endcan
                        </div>

                        <div class="flex justify-center">
                            <ul class="flex flex-wrap">
                                <li class="m-1">
                                    <a class="badge badge-sm badge-primary tooltip inline-flex" href="{{ $article->category->show_url }}" data-tip="Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg>
                                        {{ $article->category->title }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- BlogArticle title --}}
                    <h1 class="text-4xl py-8 px-6">
                        {{ $article->title }}
                    </h1>
                </header>

                {{-- BlogArticle content --}}
                <div class="prose min-w-full px-6">
                    {!! Markdown::convert($article->content) !!}
                </div>

                {{-- Author --}}
                <footer class="my-10 px-6">
                    <h3 class="divider mb-4 text-xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-14 w-14" viewBox="0 0 16 16">
                            <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5ZM9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8Zm1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Z"/>
                            <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2ZM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12V4Z"/>
                        </svg>
                        Author
                    </h3>
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">

                            {{--  Author Avatar --}}
                            <a class="avatar {{ $article->user->online ? 'avatar-online' : 'avatar-offline' }} m-2" href="{{ $article->user->show_url }}">
                                <figure class="w-16 h-16 rounded-full ring-2 ring-primary ring-offset-base-100 ring-offset-1 tooltip !overflow-visible" data-tip="{{ $article->user->username }} is {{ $article->user->online ? 'online' : 'offline' }}">
                                    <img class="rounded-full" src="{{ $article->user->avatar_small }}"  alt="{{ $article->user->full_name }} avatar" />
                                </figure>
                            </a>

                            {{-- Handle the author's icons --}}
                           <x-badge.role :user="$article->user" />
                        </div>

                        {{-- Author name & signature --}}
                        <div class="flex flex-col ml-3 self-start mt-5">
                            {{-- User --}}
                            <x-user.user
                                :user-name="$article->user->full_name"
                                :user-avatar-small="$article->user->avatar_small"
                                :user-profile="$article->user->show_url"
                                :user-last-login="$article->user->last_login_date->diffForHumans()"
                                :user-registered="$article->user->created_at->diffForHumans()"
                            />
                            <div>
                                {!! Markdown::convert($article->user->signature) !!}
                            </div>
                        </div>
                    </div>
                </footer>
            </article>

            {{-- Coments --}}
            <livewire:blog.comment :article="$article"/>

        </div>
        <aside class="lg:col-span-3 col-span-12 px-3">
            @include('Blog::partials._sidebar')
        </aside>
    </div>
</section>
@endsection
