<header class="pos-f-t">
  <div class="collapse" id="navbar-header">
      <div class="container bg-inverse p-1">
        <h3>Collapsed content</h3>
        <p>Toggleable via the navbar brand.</p>
      </div>
  </div>
  <nav class="navbar navbar-dark bg-primary bg-faded">
    <div class="container">
      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-expanded="false" aria-controls="exCollapsingNavbar2" aria-label="Toggle navigation"></button>
      <a class="navbar-brand" href="{{ route('page_index') }}">
          <img src="{{ asset('images/logo.svg') }}" width="30" height="30" class="d-inline-block align-top" alt="Logo">
          eta
      </a>
      <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('blog_article_index') }}">Blog</a>
          </li>
        </ul>

        @if (Auth::guest())
            <div class="float-sm-right">
                <a class="btn btn-outline-primary-inverse" href="{{ route('users_auth_register') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </a>
                <a class="btn btn-outline-primary-inverse" href="{{ route('users_auth_login') }}">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </div>
        @else
            <div class="navbar-text btn-group float-sm-right">
                <a href="#" class="nav-link text-white sidebar-trigger">
                    {{ Auth::user()->username }}
                </a>
            </div>
            <span class="navbar-text text-white float-xs-left float-sm-right">
              Hello,&nbsp;
            </span>
        @endif


      </div>
    </div>
  </nav>
</header>

<!-- Sidebar -->
@include('elements.sidebar')
