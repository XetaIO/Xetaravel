<header class="pos-f-t">
  <nav id="navbar" class="navbar navbar-toggleable-lg navbar-light bg-white">
    <div class="container">
      <button class="navbar-toggler hidden-lg-up float-xs-right" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-expanded="false" aria-controls="exCollapsingNavbar2" aria-label="Toggle navigation"></button>
      <a class="navbar-brand font-xeta font-weight-bold" href="{{ route('page.index') }}">
          <img src="{{ asset('images/logo.svg') }}" class="d-inline-block align-middle" alt="Logo">
          Xetaravel
      </a>
      <div class="collapse navbar-toggleable-md" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav">
          <li class="nav-item">
            <a class="nav-link-menu" href="{{ route('page.index') }}">
                <span data-hover="Home">Home</span>
            </a>
            <a class="nav-link-menu" href="{{ route('blog.article.index') }}">
                <span data-hover="Blog">Blog</span>
            </a>
            @if (config('settings.discuss.enabled') ||
              (!config('settings.discuss.enabled') && !is_null(Auth::user()) && Auth::user()->level() >= 4))
                <a class="nav-link-menu" href="{{ route('discuss.index') }}">
                    <span data-hover="Discuss">Discuss</span>
                </a>
              @endif
            <a class="nav-link-menu" href="{{ route('page.contact') }}">
                <span data-hover="Contact">Contact</span>
            </a>
          </li>
        </ul>

        @if (Auth::guest())
            <div class="float-xs-right">
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users.auth.register') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </a>
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users.auth.login') }}">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </div>
        @else
            <div class=" float-xs-left  float-lg-right" style="display: flex;">
              <span class="navbar-text navbar-hello-text font-weight-bold">
                Hello,&nbsp;
              </span>
              <div class="navbar-text btn-group font-weight-bold">
                  <a href="#" id="sidebar-trigger" class="nav-link">
                      {{ Auth::user()->username }}
                  </a>
              </div>
            </div>

            <!-- Notifications -->
            @include('partials._notifications')
        @endif


      </div>
    </div>
  </nav>
</header>

<!-- Sidebar -->
@include('elements.sidebar')
