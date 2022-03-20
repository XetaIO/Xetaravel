@extends('layouts.admin')
{!! config(['app.title' => 'Update Category']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Update : {{ Str::limit($category->title, 60) }}
        </h5>
        <div class="card-block">
            {!! Form::model($category, ['route' => ['admin.discuss.category.update', $category->id], 'method' => 'put']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Category title...']
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
                    null,
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
                    ['class' => 'form-control form-control-inverse col-md-6']
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Update', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="card-footer text-muted">
            This category was last edited on {{ $category->updated_at->formatLocalized('%d %B %Y - %T') }}
        </div>
    </div>
</div>
@endsection
