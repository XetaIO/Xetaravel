@extends('layouts.admin')
{!! config(['app.title' => 'Search an User']) !!}

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
            @if ($users->isNotEmpty())
                <ul class="list-unstyled text-muted">
                <li>Search : <code>{{ $search }}</code></li>
                <li>Type : <code>{{ $type }}</code></li>
                </ul>
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="{{ $type == 'username' ? 'table-primary' : '' }}">Username</th>
                            <th class="{{ $type == 'email' ? 'table-primary' : '' }}">Email</th>
                            <th>Roles</th>
                            <th class="{{ $type == 'registered_ip' ? 'table-primary' : '' }}">Registered IP</th>
                            <th class="{{ $type == 'last_login_ip' ? 'table-primary' : '' }}">Last login IP</th>
                            <th>Comments</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">
                                    {{ $user->id }}
                                </th>
                                <td class="{{ $type == 'username' ? 'table-primary' : '' }}">
                                    {{ link_to($user->profile_url, $user->username) }}
                                </td>
                                <td class="{{ $type == 'email' ? 'table-primary' : '' }}">
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
                                <td class="{{ $type == 'registered_ip' ? 'table-primary' : '' }}">
                                    {{ $user->register_ip }}
                                </td>
                                <td class="{{ $type == 'last_login_ip' ? 'table-primary' : '' }}">
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

                <div class="col-md 12 text-xs-center">
                    {{ $users->links() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There's no result for your search !
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer text-muted">
            There're {{ $users->count() }} users matching for your search.
        </div>
    </div>
</div>
@endsection
