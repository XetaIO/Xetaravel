@extends('layouts.app')
{!! config(['app.title' => 'Welcome !']) !!}

@push('style')
    <style>
    @media (min-width: 768px) {
        .bg-white {
            background-color: transparent !important;
        }
        .navbar {
            border-bottom: none;
        }
        .navbar-brand {
            color: #ffffff !important;
        }
        .navbar-hello-text {
            color: #ffffff !important;
        }
    }
    </style>
@endpush

@section('content')
<div class="showcase">
    <div id="particles"></div>
    <div class="container" style="padding: 250px 0;">
        <div class="row">
            <div class="col-xs-12">
                <h1>Welcome on <span class="text-primary font-xeta">Xetaravel</span> !</h1>
                <p class="description">
                    This version is a light version of the <a class="font-weight-bold" href="https://github.com/XetaIO/Xeta" target="_blank">Xeta</a> project made with <i class="fa fa-heart" style="color: #fa6c65"></i> and <a class="font-weight-bold" href="https://laravel.com" target="_blank">Laravel</a>.
                </p>
                <a class="btn btn-outline-primary-inverse" href="{{ route('blog.article.index') }}">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> Visit the Blog
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container" id="change-navbar">

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-code text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Open Source</h4>
                <p class="text-muted">
                    The code source of this website is open source and available on <a href="{{ config('xetaravel.site.github_url') }}" target="_blank">Github</a>. If you want to contribute, feel free to do a PR.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-flask text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Experiences</h4>
                <p class="text-muted">
                I use this site for my personal experiences in development, to try new things like JS libraries, or PHP libraries.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="features-box">
                <i class="fa fa-comments-o text-primary" aria-hidden="true"></i>
                <h4 class="font-xeta">Interact</h4>
                <p class="text-muted">
                You can interact with Xetaravel's members in the blog or directly with me in the comments of an article.
                </p>
            </div>
        </div>
    </div>

    <hr/>
    <h1 class="text-xs-center font-xeta mt-3 mb-3">Latest Articles</h1>

    <div class="row">

        @forelse ($articles as $article)
            <div class="col-md-4 mb-1">
                <div class="card card-outline-primary text-xs-center" style="height: 100%; margin-bottom: 60px;">

                    <div class="card-block">
                        <h4 class="card-title text-truncate" data-toggle="tooltip" title="{{ $article->title }}">
                            <a href="{{ $article->article_url }}">
                                {{ $article->title }}
                            </a>
                        </h4>

                        <small class="card-subtitle text-muted">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" title="Category"></i>
                                    <a href="{{ $article->category->category_url }}">
                                        {{ $article->category->title }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa fa-user" aria-hidden="true" data-toggle="tooltip" title="User"></i>
                                    <a href="{{ $article->user->proffile_url }}">
                                        {{ $article->user->username }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa fa-comment" aria-hidden="true"  data-toggle="tooltip" title="Comments"></i>
                                    {{ $article->comment_count }}
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa fa-calendar" aria-hidden="true"  data-toggle="tooltip" title="Date"></i>
                                    <time datetime="{{ $article->created_at->format('c') }}" title="{{ $article->created_at->format('c') }}" data-toggle="tooltip">
                                        {{ $article->created_at->format('Y-m-d') }}
                                    </time>
                                </li>
                            </ul>
                        </small>

                        <div class="card-text">
                            {!! Markdown::convertToHtml(str_limit($article->content, 120)) !!}
                        </div>
                    </div>

                    <div class="card-footer" style="position: absolute; bottom: 0; width: 100%;">
                        <a href="{{ $article->article_url }}" class="card-link btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    There's no article yet, come back later !
                </div>
            </div>
        @endforelse
    </div>

    <hr/>
    <h1 class="text-xs-center font-xeta mt-3 mb-3">Latest Comments</h1>

    <div class="row pb-3">
        @forelse ($comments as $comment)
            <div class="col-md-6">
                <div class="media">

                    <div class="media-left">
                        <a href="{{ $comment->user->profile_url }}">
                            <img class="media-object" src="{{ asset($comment->user->avatar_small) }}" alt="Avatar" height="64px" width="64px">
                        </a>
                    </div>

                    <div class="media-body">
                        <h5 class="media-heading">
                            <a href="{{ $comment->comment_url }}">
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> {{ $comment->article->title }}
                            </a>
                        </h5>

                        <small class="text-muted">
                            <i class="fa fa-calendar" aria-hidden="true"  data-toggle="tooltip" title="Date"></i>
                            <time datetime="{{ $comment->created_at->format('c') }}" title="{{ $comment->created_at->format('c') }}" data-toggle="tooltip">
                                {{ $comment->created_at }}
                            </time>
                        </small>

                        <div>
                            {!! Markdown::convertToHtml(str_limit($comment->content, 250)) !!}
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-primary" role="alert">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    There's no comment yet, come back later !
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-header-register-login').removeClass('btn-outline-primary').addClass('btn-outline-primary-inverse');
        });
    </script>
    <script type="text/javascript">
    particlesJS("particles", {
      "particles": {
        "number": {
          "value": 200,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color" : {
          "value": "#fff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          },
          "polygon": {
            "nb_sides": 5
          }
        },
        "opacity": {
          "value": 0.5,
          "random": true,
          "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 7,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 3,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked":{
          "enable": false,
          "distance": 500,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 2
        },
        "move":{
          "enable": true,
          "speed": 3,
          "direction": "bottom",
          "random": false,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY":1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "bubble"
          },
          "onclick": {
            "enable": true,
            "mode":"push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 400,
            "line_linked": {
              "opacity":0.5
            }
          },
          "bubble": {
            "distance": 400,
            "size": 4,
            "duration": 0.3,
            "opacity": 1,
            "speed": 3
          },
          "repulse": {
            "distance": 200,
            "duration": 0.4
          },
          "push": {
            "particles_nb": 4
          },
          "remove": {
            "particles_nb": 2
          }
        }
      },
      "retina_detect":true
    });
    </script>
@endpush
