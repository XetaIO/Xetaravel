@extends('layouts.admin')
{!! config(['app.title' => 'Manage Permissions']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Permissions
        </h5>

        <div class="card-block">
            {{ link_to(route('admin.role.permission.create'), '<i class="fa fa-plus"></i> New Permission', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}

            @if ($permissions->isNotEmpty())
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Model</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <th scope="row">
                                    {{ $permission->id }}
                                </th>
                                <td>
                                    {{ $permission->name }}
                                </td>
                                <td>
                                    <code>{{ $permission->slug }}</code>
                                </td>
                                <td>
                                    {{ Str::limit($permission->description, 60) }}
                                </td>
                                <td>
                                    {{ $permission->model }}
                                </td>
                                <td>
                                    {{ $permission->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.role.permission.edit', ['slug' => $permission->slug, 'id' => $permission->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this permission'
                                        ],
                                        null,
                                        false
                                    ) }}

                                    @if ($permission->is_deletable)
                                        {{ link_to(
                                            route('admin.role.permission.delete', ['id' => $permission->id]),
                                            '<i class="fa fa-remove"></i>',
                                            [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete this permission',
                                                'onclick' => "event.preventDefault();document.getElementById('delete-form').submit();"
                                            ],
                                            null,
                                            false
                                        ) }}
                                        {!! Form::open([
                                            'route' => ['admin.role.permission.delete', 'id' => $permission->id],
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
                    {{ $permissions->render() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There's no permission yet, create the first permission now !
                    </div>
                </div>
            @endif

        </div>
        <div class="card-footer">
            There're {{ $permissions->count() }} permissions.
        </div>
    </div>
</div>
@endsection
