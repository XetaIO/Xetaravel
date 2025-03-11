@extends('layouts.admin')
{!! config(['app.title' => 'Create an BlogArticle']) !!}

@push('meta')
    <x-meta title="Create an Article" />
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
        <h1 class="text-4xl font-xetaravel">
            Create an Article
        </h1>
        <p class="text-gray-400 dark:text-gray-500">
            Create an article in the Blog.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-200 dark:bg-base-300 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
            <x-form.form method="post" action="{{ route('admin.blog.article.create') }}" enctype="multipart/form-data">
                <x-form.text name="title" label="Title" placeholder="Article title..." required autofocus />

                <x-form.select  name="category_id"  label="Category" required>
                    @foreach($categories as $id => $title)
                        <option  value="{{ $id }}">{{$title}}</option>
                    @endforeach
                </x-form.select>

                <x-form.checkbox name="is_display" label="Displayed" checked>
                    Check to display this article
                </x-form.checkbox>

                <div class="form-control">
                    <label class="label" for="banner">
                        <span class="label-text">Banner</span>
                    </label>

                    <div class="max-h-[350px] max-w-[870px] rounded-xl ring ring-white ring-offset-base-100 ring-offset-2 overflow-hidden mb-5">
                        <img class="w-full object-contain rounded-xl" src="{{ asset('images/articles/default_banner.jpg') }}"  alt="Default article banner"/>
                    </div>

                    <x-form.file name="banner" class="max-w-sm" />
                    <label class="label">
                        <span class="label-text-alt">Recommended size: 870x350px</span>
                    </label>
                </div>

                <x-form.textarea name="content" label="Content" editor="articleEditor" required>
                    {{ old('content') }}
                </x-form.textarea>

                <button type="submit" class="btn gap-2">
                    <i class="fa-solid fa-plus"></i>
                    Create
                </button>
            </x-form.form>
        </div>
    </div>
</section>
@endsection
