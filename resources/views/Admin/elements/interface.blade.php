<nav class="col-sm-12 col-md-2 bg-inverse interface">
    <div class="interface-header hidden-md">
        <img src="{{ Auth::user()->avatar_small }}" class="avatar" alt="Avatar">
        <div class="information">
            <div class="text-white font-xeta">
                {{ Auth::user()->full_name }}

                <a href="{{ route('users.auth.logout') }}" class="float-xs-right" data-toggle="tooltip" data-placement="right" data-container="body" title="Logout"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                </a>
                <form id="logout-form" action="{{ route('users.auth.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <p class="p-1 m-0 text-white font-xeta">
        Administration
    </p>
    <ul class="nav nav-pills flex-column mb-0">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
  </ul>
  <p class="p-1 m-0 text-white font-xeta">
      Blog
  </p>
  <ul class="nav nav-pills flex-column mb-0">
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="fa fa-newspaper-o"></i> Manage Articles</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="fa fa-tags"></i> Manage Categories</a>
    </li>
  </ul>
  <p class="p-1 m-0 text-white font-xeta">
      Users
  </p>
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="fa fa-users"></i> Manage Users</a>
    </li>
  </ul>
</nav>
