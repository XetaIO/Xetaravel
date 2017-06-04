@extends('layouts.app')
{!! config(['app.title' => 'Users']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-12">
            <h4 class="font-xeta">
                All users from {{ config('app.name') }} :
            </h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full name</th>
                        <th>Roles</th>
                        <th>Comments</th>
                        <th>Last login</th>
                        <th>Created</th>
                        @permission('manage.users')
                            <th>Action</th>
                        @endpermission
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ link_to($user->profile_url, $user->username) }}
                            </td>
                            <td>
                                {{ $user->full_name }}
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
                                {{ $user->comment_count }}
                            </td>
                            <td>
                                {{ $user->last_login->formatLocalized('%d %B %Y - %T') }}
                            </td>
                            <td>
                                {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                            </td>
                            @permission('manage.users')
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
                            @endpermission
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="col-md 12 text-xs-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
