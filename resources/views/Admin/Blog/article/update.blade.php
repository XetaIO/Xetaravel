@extends('layouts.admin')
{!! config(['app.title' => 'Update BlogArticle']) !!}

@push('meta')
    <x-meta title="Update Article" />
@endpush

@push('style')
    {!! editor_css() !!}
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $articleConfig = [
            'id' => 'articleEditor',
            'height' => '550'
        ];
    @endphp

    @include('editor/partials/_article', $articleConfig)
@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl">
            Update an Article
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Update an article in the Blog.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
            <div class="text-sm mb-5 text-right opacity-60">
                This article was last edited on {{ $article->updated_at->formatLocalized('%d %B %Y - %T') }}
            </div>
            <x-form.form method="put" action="{{ route('admin.blog.article.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
                <x-form.text name="title" label="Title" placeholder="Article title..." value="{{ $article->title }}" required autofocus />

                <x-form.select  name="category_id"  label="Category" required>
                    @foreach($categories as $id => $title)
                        <option value="{{ $id }}" {{ $id == $article->category_id ? 'selected' : '' }}>
                            {{$title}}
                        </option>
                    @endforeach
                </x-form.select>

                @php
                    $checked = (bool)$article->is_display == true ? 'checked="checked"' : '';
                @endphp

                <x-form.checkbox name="is_display" label="Displayed" checked="{{ (bool)$article->is_display }}">
                    Check to display this article
                </x-form.checkbox>

                <div class="form-control">
                    <label class="label" for="banner">
                        <span class="label-text">Banner</span>
                    </label>

                    <div class="max-h-[350px] max-w-[870px] rounded-xl ring ring-white ring-offset-base-100 ring-offset-2 overflow-hidden mb-5">
                        <img class="h-full w-full object-cover rounded-xl" src="{{ $article->article_banner }}"  alt="Article banner"/>
                    </div>

                    <x-form.file name="banner" class="max-w-sm" />
                    <label class="label">
                        <span class="label-text-alt">Recommended size: 870x350px</span>
                    </label>
                </div>

                <x-form.textarea name="content" label="Content" editor="articleEditor" required>
                    {{ old('content', $article->content) }}
                </x-form.textarea>

                <button type="submit" class="btn gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Update
                </button>
            </x-form.form>
        </div>
    </div>
</section>
@endsection
