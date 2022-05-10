@if (Auth::user())
<menu class="sidebar sidebar-closed" id="sidebar">
    <div class="sidebar-container">
        <ul class="nav sidebar-menu">
            <li>
                <a href="{{ Auth::user()->profile_url }}" class="sidebar-avatar hidden-sm-down" title="Visit your profile !" data-toggle="tooltip" data-placement="left" data-container="body">
                    <img src="{{ asset(Auth::user()->avatar_small) }}" alt="avatar">
                </a>
                <!-- Responsive link -->
                <a href="{{ Auth::user()->profile_url }}" class="sidebar-avatar hidden-md-up">
                    <img src="{{ asset(Auth::user()->avatar_small) }}" alt="avatar">
                </a>
            </li>
            @permission('access.administration')
                <li>
                    <a href="{{ route('admin.page.index') }}" class="hidden-sm-down" title="Access to the site administration." data-toggle="tooltip" data-placement="left" data-container="body">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                    <!-- Responsive link -->
                    <a href="{{ route('admin.page.index') }}" class="hidden-md-up">
                        <i class="fa fa-dashboard"></i>
                        <small class="sidebar-text">Dashboard</small>
                    </a>
                </li>
            @endpermission

            <li>
                <a href="{{ route('users.account.index') }}" class="hidden-sm-down" title="Manage your account settings." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">My Account</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.account.index') }}" class="hidden-md-up">
                    <i class="fas fa-user-edit"></i>
                    <small class="sidebar-text">My Account</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.notification.index') }}" class="hidden-sm-down" title="Check your new and old notifications." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.notification.index') }}" class="hidden-md-up">
                    <i class="fas fa-user-tag"></i>
                    <small class="sidebar-text">Notifications</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.security.index') }}" class="hidden-sm-down" title="Manage the security of your account." data-toggle="tooltip" data-placement="left" data-container="body">
                    <i class="fas fa-user-lock"></i>
                    <small class="sidebar-text">Security</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.security.index') }}" class="hidden-md-up">
                    <i class="fas fa-user-lock"></i>
                    <small class="sidebar-text">Security</small>
                </a>
            </li>

            <li>
                <a href="{{ route('users.auth.logout') }}"  class="hidden-sm-down text-danger" title="See you later !" data-toggle="tooltip" data-placement="left" data-container="body"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Logout</small>
                </a>
                <!-- Responsive link -->
                <a href="{{ route('users.auth.logout') }}" class="hidden-md-up text-danger"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <small class="sidebar-text">Logout</small>
                </a>
                {!! Form::open([
                    'route' => 'users.auth.logout',
                    'id' => 'logout-form',
                    'method' => 'post',
                    'style' => 'display: none;'
                ]) !!}
                {!! Form::close() !!}
            </li>
        </ul>
    </div>
</menu>
@endif
