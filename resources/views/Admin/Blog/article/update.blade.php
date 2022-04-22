@extends('layouts.admin')
{!! config(['app.title' => 'Update Article']) !!}

@push('meta')
    <x-meta title="Update Article" />
@endpush

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
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
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Update : {{ Str::limit($article->title, 60) }}
        </h5>
        <div class="card-block">
            {!! Form::model($article, ['route' => ['admin.blog.article.update', $article->id], 'files'=>'true', 'method' => 'put']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Article title...']
                ) !!}

                {!! Form::bsSelect(
                    'category_id',
                    $categories,
                    'Category',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-2']
                ) !!}

                {!! Form::bsCheckbox(
                    "is_display",
                    null,
                    null,
                    "Check to display this article",
                    [
                        'label' => 'Display',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ]
                ) !!}

                <div class="form-group mb-2 {{ $errors->has('banner') ? 'has-danger' : '' }}">
                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                        <div class="fileinput-new">
                            <img src="{{ $article->article_banner }}" alt="Default Banner">
                        </div>
                        <div class="fileinput-preview fileinput-exists">
                            <img src="{{ $article->article_banner }}" alt="Article Banner">
                        </div>
                        <div class="mt-1">
                            <span class="btn btn-outline-primary btn-file">
                                <i class="fa fa-refresh"></i>
                                <span class="fileinput-exists">Change</span>
                                    {!! Form::file('banner') !!}
                            </span>
                            <span class="text-muted">Recommended size : 825x250px<span>
                        </div>
                    </div>
                    @if ($errors->has('banner'))
                        <div class="form-control-feedback">
                            {{ $errors->first('banner') }}
                        </div>
                    @endif
                </div>

                {!! Form::bsTextarea(
                    'content',
                    'Content',
                    old('content'),
                    [
                        'class' => 'form-control form-control-inverse',
                        'required' => 'required',
                        'editor' => 'articleEditor',
                        'style' => 'display:none;'
                    ]
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Update', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="card-footer text-muted">
            This article was last edited on {{ $article->updated_at->formatLocalized('%d %B %Y - %T') }}
        </div>
    </div>
</div>
@endsection
