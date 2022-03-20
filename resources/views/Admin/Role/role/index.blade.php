@extends('layouts.admin')
{!! config(['app.title' => 'Manage Roles']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Roles
        </h5>

        <div class="card-block">
            {{ link_to(route('admin.role.role.create'), '<i class="fa fa-plus"></i> New Role', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}

            @if ($roles->isNotEmpty())
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Level</th>
                            <th>Users Count</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">
                                    {{ $role->id }}
                                </th>
                                <td>
                                    <span style="{{ $role->css }}">{{ $role->name }}</span>
                                </td>
                                <td>
                                    {{ Str::limit($role->description, 60) }}
                                </td>
                                <td>
                                    {{ $role->level }}
                                </td>
                                <td>
                                    {{ $role->users->count() }}
                                </td>
                                <td>
                                    {{ $role->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.role.role.edit', ['id' => $role->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this role'
                                        ],
                                        null,
                                        false
                                    ) }}

                                    @if ($role->is_deletable)
                                        {{ link_to(
                                            route('admin.role.role.delete', ['id' => $role->id]),
                                            '<i class="fa fa-remove"></i>',
                                            [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete this role',
                                                'onclick' => "event.preventDefault();document.getElementById('delete-form').submit();"
                                            ],
                                            null,
                                            false
                                        ) }}
                                        {!! Form::open([
                                            'route' => ['admin.role.role.delete', 'id' => $role->id],
                                            'method' => 'delete',
                                            'id' => 'delete-form',
                                            'style' => 'display: none;'
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="col-md 12 text-xs-center">
                    {{ $roles->render() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There's no role yet, create the first role now !
                    </div>
                </div>
            @endif

        </div>
        <div class="card-footer">
            There're {{ $roles->count() }} roles.
        </div>
    </div>
</div>
@endsection
