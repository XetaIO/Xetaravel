<nav class="col-sm-12 col-md-2 bg-inverse interface">
    <div class="interface-header hidden-md">
        <img src="{{ Auth::user()->avatar_small }}" class="avatar" alt="Avatar">
        <div class="information">
            <div class="text-white font-xeta">
                {{ Auth::user()->full_name }}

                <a href="{{ route('users.auth.logout') }}" class="float-xs-right" data-toggle="tooltip" data-container="body" title="Logout"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                </a>
                {!! Form::open([
                    'route' => 'users.auth.logout',
                    'id' => 'logout-form',
                    'method' => 'post',
                    'style' => 'display: none;'
                ]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <p class="p-1 m-0 text-white font-xeta">
        Administration
    </p>
    {!! Menu::{'admin.administration'}() !!}

    @permission('manage.blog')
        <p class="p-1 m-0 text-white font-xeta">
            Blog
        </p>
        {!! Menu::{'admin.blog'}() !!}
    @endpermission

    @permission('manage.discuss.categories')
        <p class="p-1 m-0 text-white font-xeta">
            Discuss
        </p>
        {!! Menu::{'admin.discuss'}() !!}
    @endpermission

    @permission('manage.users')
        <p class="p-1 m-0 text-white font-xeta">
            Users
        </p>
        {!! Menu::{'admin.user'}() !!}
    @endpermission

    @permission('manage.roles')
        <p class="p-1 m-0 text-white font-xeta">
            Roles
        </p>
        {!! Menu::{'admin.role'}() !!}
    @endpermission
</nav>
