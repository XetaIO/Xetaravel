<header class="pos-f-t">
  <div class="collapse" id="navbar-header">
      <div class="container bg-inverse p-1">
        <h3>Collapsed content</h3>
        <p>Toggleable via the navbar brand.</p>
      </div>
  </div>
  <nav class="navbar navbar-light bg-white">
    <div class="container">
      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-expanded="false" aria-controls="exCollapsingNavbar2" aria-label="Toggle navigation"></button>
      <a class="navbar-brand font-xeta font-weight-bold" href="{{ route('page_index') }}">
          <img src="{{ asset('images/logo.svg') }}" width="25" height="25" class="d-inline-block align-middle" alt="Logo">
          Xetaravel
      </a>
      <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav">
          <li class="nav-item">
            <a class="nav-link-menu" href="{{ route('page_index') }}">
                <span data-hover="Home">Home</span>
            </a>
            <a class="nav-link-menu" href="{{ route('blog_article_index') }}">
                <span data-hover="Blog">Blog</span>
            </a>
          </li>
        </ul>

        @if (Auth::guest())
            <div class="float-sm-right">
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users_auth_register') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </a>
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users_auth_login') }}">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </div>
        @else
            <div class="navbar-text btn-group float-sm-right font-weight-bold">
                <a href="#" class="nav-link sidebar-trigger">
                    {{ Auth::user()->username }}
                </a>
            </div>
            <span class="navbar-text navbar-hello-text float-xs-left float-sm-right font-weight-bold">
              Hello,&nbsp;
            </span>
            <!-- Notifications -->
            @include('elements._notifications')
        @endif


      </div>
    </div>
  </nav>
</header>

<!-- Sidebar -->
@include('elements.sidebar')