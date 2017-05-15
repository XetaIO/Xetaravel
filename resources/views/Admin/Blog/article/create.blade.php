@extends('layouts.admin')
{!! config(['app.title' => 'Create an Article']) !!}

@push('scripts')
    {!! Html::script('/vendor/ckeditor/release/ckeditor.js') !!}

    <script type="text/javascript">
        /**
         * CKEditor
         */
        CKEDITOR.plugins.addExternal('pbckcode', '{{ asset('/vendor/ckeditor/plugins/pbckcode-1.2.5/src/plugin.js') }}');
        CKEDITOR.replace('contentBox', {
            customConfig: '../config/article.js'
        });
    </script>
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
            {!! Form::open(['route' => 'admin.blog.article.create', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'Article title...',
                        'required' => 'required',
                        'autofocus'
                    ],
                    'form-control-label form-control-label-inverse'
                ) !!}

                {!! Form::bsSelect(
                    'category_id',
                    $categories,
                    'Category',
                    1,
                    ['class' => 'form-control form-control-inverse col-md-2', 'required' => 'required'],
                    'form-control-label form-control-label-inverse'
                ) !!}

                {!! Form::bsCheckbox(
                    "is_display",
                    null,
                    1,
                    "Check to display this article",
                    [
                        'label' => 'Display',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ],
                    'form-control-label form-control-label-inverse'
                ) !!}

                {!! Form::bsTextarea(
                    'content',
                    'Content',
                    null,
                    ['id' => 'contentBox', 'class' => 'form-control form-control-inverse', 'required' => 'required'],
                    'form-control-label form-control-label-inverse'
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Create', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
