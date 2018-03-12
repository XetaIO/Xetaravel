@extends('layouts.admin')
{!! config(['app.title' => 'Create a Category']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Create a category
        </h5>
        <div class="card-block">
            {!! Form::open(['route' => 'admin.discuss.category.create', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'Category title...',
                        'required' => 'required',
                        'autofocus'
                    ]
                ) !!}

                {!! Form::bsText(
                    'color',
                    'Color',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-2',
                        'placeholder' => '#color...'
                    ]
                ) !!}

                {!! Form::bsCheckbox(
                    'is_locked',
                    null,
                    0,
                    'Check to lock this category',
                    [
                        'label' => 'Locked',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ]
                ) !!}

                {!! Form::bsTextarea(
                    'description',
                    'Description',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'required' => 'required']
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
