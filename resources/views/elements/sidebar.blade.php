@if (Auth::user())
<menu class="sidebar sidebar-closed" id="sidebar">
    <div class="sidebar-container">
        <ul class="nav sidebar-menu">
            <a href="{{ route('users_user_show', ['slug' => Auth::user()->slug, 'id' => Auth::user()->id]) }}" class="sidebar-avatar" title="Visit your profile !" data-toggle="tooltip" data-placement="left" data-container="body">
                <img src="{{ asset(Auth::user()->avatar) }}" alt="avatar">
            </a>
            @permission('access.administration')
                <li>
                    <a href="{{ route('admin_page_index') }}" class="hidden-xs-down" title="Access to the site administration." data-toggle="tooltip" data-placement="left" data-container="body">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                    <!-- Responsive link -->
                    <a href="{{ route('admin_page_index') }}" class="hidden-sm-up">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                </li>
            @endpermission

            <li>
                <a href="{{ route('users_account_index') }}" class="hidden-xs-down" title="Manage your account settings." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fa fa-cogs"></i>
                    <small class="sidebar-text">My Account</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users_account_index') }}" class="hidden-sm-up">
                    <i class="fa fa-cogs"></i>
                    <small class="sidebar-text">My Account</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users_auth_logout') }}"  class="hidden-xs-down text-danger" title="See you later !" data-toggle="tooltip" data-placement="left" data-container="body"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Logout</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users_auth_logout') }}" class="hidden-sm-up text-danger"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Logout</small>
                </a>
                <form id="logout-form" action="{{ route('users_auth_logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</menu>
@endif
