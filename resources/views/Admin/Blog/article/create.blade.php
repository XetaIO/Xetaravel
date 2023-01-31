@extends('layouts.admin')
{!! config(['app.title' => 'Create an Article']) !!}

@push('meta')
    <x-meta title="Create an Article" />
@endpush

@push('style')
    {!! editor_css() !!}
    <link href="{{ asset('css/editor-md.custom.min.css') }}" rel="stylesheet">
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
            Create an article
        </h5>
        <div class="card-block">
            {!! Form::open(['route' => 'admin.blog.article.create', 'files'=>'true', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'Article title...',
                        'required' => 'required',
                        'autofocus'
                    ]
                ) !!}

                {!! Form::bsSelect(
                    'category_id',
                    $categories,
                    'Category',
                    1,
                    ['class' => 'form-control form-control-inverse col-md-2', 'required' => 'required']
                ) !!}

                {!! Form::bsCheckbox(
                    'is_display',
                    null,
                    1,
                    'Check to display this article',
                    [
                        'label' => 'Display',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ]
                ) !!}

                <div class="form-group mb-4 {{ $errors->has('banner') ? 'has-danger' : '' }}">
                    <label for="banner" class="form-control-label">Banner</label>

                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                        <div class="fileinput-new">
                            <img src="{{ asset('images/articles/default_banner.jpg') }}" alt="Default Banner">
                        </div>
                        <div class="fileinput-preview fileinput-exists">
                            <img src="{{ asset('images/articles/default_banner.jpg') }}" alt="Article Banner">
                        </div>
                        <div class="mt-1">
                            <span class="btn btn-outline-primary btn-file">
                                <i class="fa fa-refresh"></i>
                                <span class="fileinput-exists">Change</span>
                                    {!! Form::file('banner') !!}
                            </span>
                            <span class="text-muted">Recommended size : 825x250px</span>
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
                        {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Create', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
