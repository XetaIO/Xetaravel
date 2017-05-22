@extends('layouts.admin')
{!! config(['app.title' => 'Update ' . e($role->name)]) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Update : {{ $role->name }}
        </h5>

        <div class="card-block">

            @if ($role->permissions()->get()->contains($permission))
                <p class="text-danger">
                    Be careful when editing the permissions, you can remove the administration access for this role !
                </p>
            @endif

            {!! Form::model(
                $role,
                [
                    'route' => ['admin.role.role.update', $role->id],
                    'method' => 'put'
                ]
            ) !!}

                {!! Form::bsText(
                    'name',
                    'Name',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Role name...']
                ) !!}

                {!! Form::bsText(
                    'css',
                    'CSS',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'formText' => 'This CSS is used to color the role name everywhere on the website.',
                        'placeholder' => 'Role css...']
                ) !!}

                {!! Form::bsNumber(
                    'level',
                    'Level',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6']
                ) !!}

                {!! Form::bsSelect(
                    'permissions[]',
                    $permissions,
                    'Permissions',
                    $role->permissions->pluck('id')->toArray(),
                    ['class' => 'form-control form-control-inverse col-md-6', 'multiple'],
                    $optionsAttributes
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
