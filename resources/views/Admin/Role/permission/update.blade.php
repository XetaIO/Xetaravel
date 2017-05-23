@extends('layouts.admin')
{!! config(['app.title' => 'Update ' . e($permission->name)]) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Update : {{ $permission->name }}
        </h5>

        <div class="card-block">

            <p class="text-danger">
                Be careful when editing the permission's name, it will change the slug !
            </p>

            {!! Form::model(
                $permission,
                [
                    'route' => ['admin.role.permission.update', $permission->id],
                    'method' => 'put'
                ]
            ) !!}

                {!! Form::bsText(
                    'name',
                    'Name',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Role name...']
                ) !!}

                {!! Form::bsTextarea(
                    'description',
                    'Description',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Role description...']
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Update', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
