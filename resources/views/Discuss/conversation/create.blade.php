@extends('layouts.app')
{!! config(['app.title' => 'Start a discussion']) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $config = [
            'id' => 'conversationEditor',
            'height' => '350'
        ];
    @endphp

    @include('editor/partials/_comment', $config)


    <script src="{{ mix('js/highlight.min.js') }}"></script>
    <script type="text/javascript">
        /* HighlightJS */
        hljs.initHighlightingOnLoad();
    </script>
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-3">

    <div class="row">
        <div class="col-md-3">
            @include('Discuss::partials._sidebar')
        </div>
        <div class="col-md-9">
            <h3 class="text-xs-center">
                Start a discussion
            </h3>
            {!! Form::open(['route' => 'discuss.conversation.create', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    [
                        'class' => 'form-control col-md-6',
                        'placeholder' => 'Discussion title...',
                        'required' => 'required',
                        'autofocus'
                    ]
                ) !!}

                {!! Form::bsSelect(
                    'category_id',
                    $categories,
                    'Category',
                    1,
                    ['class' => 'form-control col-md-3', 'required' => 'required']
                ) !!}

                {!! Form::bsTextarea(
                    'content',
                    'Content',
                    old('content'),
                    [
                        'class' => 'form-control',
                        'required' => 'required',
                        'editor' => 'conversationEditor',
                        'style' => 'display:none;'
                    ]
                ) !!}

                @permission ('manage.discuss.conversations')
                    <div class="form-group">
                        <h5 class="text-muted">
                            Moderation
                        </h5>
                    </div>

                    {!! Form::bsCheckbox(
                        'is_locked',
                        null,
                        0,
                        'Check to lock this discussion',
                        [
                            'label' => 'Is Locked ?',
                            'labelClass' => 'custom-control custom-checkbox d-block'
                        ]
                    ) !!}

                    {!! Form::bsCheckbox(
                        'is_pinned',
                        null,
                        0,
                        'Check to pin this discussion',
                        [
                            'label' => 'Is Pinned ?',
                            'labelClass' => 'custom-control custom-checkbox d-block'
                        ]
                    ) !!}
                @endpermission

                <div class="form-group text-xs-center">
                    {!! Form::button(
                        '<i class="fa fa-pencil" aria-hidden="true"></i> Start the Discussion',
                        ['type' => 'submit', 'class' => 'btn btn-outline-primary']
                    ) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection