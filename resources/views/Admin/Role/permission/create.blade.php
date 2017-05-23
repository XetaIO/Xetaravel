@extends('layouts.admin')
{!! config(['app.title' => 'Create a Permission']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Create a Permission
        </h5>

        <div class="card-block">

            {!! Form::open(['route' => 'admin.role.permission.create', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'name',
                    'Name',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Permission name...']
                ) !!}

                {!! Form::bsTextarea(
                    'description',
                    'Description',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Permission description...']
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
