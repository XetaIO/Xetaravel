@extends('layouts.admin')
{!! config(['app.title' => 'Manage Users']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Search an User
        </h5>

        <div class="card-block">
            {!! Form::open(['route' => 'admin.user.user.search', 'method' => 'get']) !!}

                {!! Form::bsText(
                    'search',
                    'Search',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-5',
                        'required' => 'required',
                        'autofocus'
                    ],
                    'form-control-label form-control-label-inverse'
                ) !!}

                {!! Form::bsRadio(
                    'type',
                    'username',
                    1,
                    'Username',
                    [
                        'label' => 'Type',
                        'labelClass' => 'custom-control custom-radio form-control-inverse d-block'
                    ],
                    'form-control-label form-control-label-inverse'
                ) !!}
                {!! Form::bsRadio(
                    'type',
                    'email',
                    false,
                    'E-mail',
                    ['labelClass' => 'custom-control custom-radio form-control-inverse d-block']
                ) !!}
                {!! Form::bsRadio(
                    'type',
                    'register_ip',
                    false,
                    'Registered IP',
                    ['labelClass' => 'custom-control custom-radio form-control-inverse d-block']
                ) !!}
                {!! Form::bsRadio(
                    'type',
                    'last_login_ip',
                    false,
                    'Last login IP',
                    ['labelClass' => 'custom-control custom-radio form-control-inverse d-block']
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i> Search', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

        @if ($latestUsers->isNotEmpty())
            <div class="card-footer">
                <h5 class="mb-1">
                    Latest registered users
                </h5>

                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Registered IP</th>
                            <th>Last login IP</th>
                            <th>Comments</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestUsers as $user)
                            <tr>
                                <th scope="row">
                                    {{ $user->id }}
                                </th>
                                <td>
                                    {{ link_to($user->profile_url, $user->username) }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @forelse ($user->roles as $role)
                                        <span style="{{ $role->css }}">
                                            {{ $role->name }}
                                        </span>
                                        <br />
                                    @empty
                                        This user does not have a role.
                                    @endforelse
                                </td>
                                <td>
                                    {{ $user->register_ip }}
                                </td>
                                <td>
                                    {{ $user->last_login_ip }}
                                </td>
                                <td>
                                    {{ $user->comment_count }}
                                </td>
                                <td>
                                    {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.user.user.edit', ['slug' => $user->slug, 'id' => $user->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this user'
                                        ],
                                        null,
                                        false
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif
    </div>
</div>
@endsection
