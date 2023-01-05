@extends('layouts.app')
{!! config(['app.title' => 'Welcome !']) !!}

@push('meta')
  <x-meta title="Welcome !" />
@endpush

@push('style')
    <style>
    @media (min-width: 993px) {
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

@push('scripts')
<script src="{{ mix('js/home.min.js') }}"></script>
<script type="text/javascript">
    var options = {
        strings: ['<span class="token comment terminal-unselectable" spellcheck="true"><span class="hljs-comment"># Create the project and install librairies</span></span><br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">composer</span> create-project xetaio/xetaravel <span class="token operator">&lt;</span>application_name<span class="token operator">&gt;</span><br/><br/><span class="token comment terminal-unselectable" spellcheck="true"><span class="hljs-comment"># Run the migration and seed the database</span></span><br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">php</span> artisan migrate<br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">php</span> artisan db:seed<br/><br/><span class="token comment terminal-unselectable" spellcheck="true"><span class="hljs-comment"># Finally, you need to install and build the JS, CSS and Vue</span></span><br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">php</span> artisan vendor:publish --provider<span class="token operator">=</span><span class="token string"><span class="hljs-string">"Xetaio\\Editor\\EditorServiceProvider"</span></span><br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">npm</span> run install<br/><span class="hljs-meta terminal-unselectable">&gt;</span><span class="terminal-unselectable"> $ </span><span class="token function">npm</span> run production'],
        typeSpeed: 40,
        backSpeed: 2,
        backDelay: 50000,
        loop: true,
        showCursor: false,
        contentType: 'html'
    };

    var typed = new Typed('.terminal-container-code', options);

    var options2 = {
        strings: ['Welcome on <span class="text-primary font-xeta">Xetaravel</span> !'],
        typeSpeed: 100,
        loop: false,
        showCursor: false,
        contentType: 'html'
    };
    var typed = new Typed('.xetaravel-typed', options2);

    var scene = document.getElementById('parallax-header');
    var parallaxInstance = new Parallax(scene);

</script>
@endpush

@section('content')
<section class="showcase">
    <div id="particles"></div>
    <div class="container pt-9 pb-9">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h1 class="xetaravel-typed"></h1>
                <p class="description">
                    This website was made to try <a class="font-weight-bold" href="https://laravel.com" target="_blank">Laravel</a> and to do my personnal website and I have decided to release it to help people starting with <a class="font-weight-bold" href="https://laravel.com" target="_blank">Laravel</a>.<br/>
                    Project <i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-coffee" style="color: #826644"></i> and <a class="font-weight-bold" href="https://laravel.com" target="_blank">Laravel</a>.
                </p>
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <a class="btn btn-primary btn-primary-shadow" href="{{ route('blog.article.index') }}">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i> Visit the Blog
                        </a>
                        <a class="btn btn-primary btn-primary-shadow" href="{{ route('discuss.index') }}">
                            <i class="fa fa-comment-o" aria-hidden="true"></i> Visit Discuss
                        </a>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <p class="font-weight-bold">
                            Want to hire me ? Check my online CV !
                        </p>
                        <a class="btn btn-primary btn-primary-shadow" href="{{ route('page.aboutme') }}">
                            <i class="far fa-address-card" aria-hidden="true"></i> Check Emeric's CV
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div id="parallax-header" class="parallax mx-auto" style="max-width: 526px;">
                    <div class="parallax-layer position-relative" data-depth="0.1">
                        <img src="{{ asset('images/parallax/layer01.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.16">
                        <img src="{{ asset('images/parallax/layer02.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.38">
                        <img src="{{ asset('images/parallax/layer03.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.16">
                        <img src="{{ asset('images/parallax/layer04.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.16">
                        <img src="{{ asset('images/parallax/layer05.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.4">
                        <img src="{{ asset('images/parallax/php.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.3">
                        <img src="{{ asset('images/parallax/laravel.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.2">
                        <img src="{{ asset('images/parallax/sass.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.4">
                        <img src="{{ asset('images/parallax/javascript.svg') }}" alt="Layer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-features-box pb-3" id="change-navbar">
    <figure class="svg-line">
        <img src="{{ asset('images/figures/svg-line.svg') }}" alt="SVG Line">
	</figure>
    <figure class="svg-glass-pot">
        <img src="{{ asset('images/figures/svg-glass-pot.svg') }}" alt="SVG Glass Pot">
	</figure>
    <figure class="svg-compass">
        <img src="{{ asset('images/figures/svg-compass.svg') }}" alt="SVG Compass">
	</figure>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="features-box">
                    <img class="features-box-image" src="{{ asset('images/icons/code.svg') }}" alt="Code Icon">
                    <div class="features-box-title font-xeta">Open Source</div>
                    <p class="text-muted">
                        The code source of this website is open source and available on <a href="{{ config('xetaravel.site.github_url') }}" target="_blank">Github</a>. If you want to contribute, feel free to do a PR.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="features-box">
                    <img class="features-box-image" src="{{ asset('images/icons/experiences.svg') }}" alt="Experiences Icon">
                    <div class="features-box-title font-xeta">Experiences</div>
                    <p class="text-muted">
                    I use this site for my personal experiences in development, to try new things like JS libraries, or PHP libraries.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="features-box">
                    <img class="features-box-image" src="{{ asset('images/icons/chat.svg') }}" alt="Chat Icon">
                    <div class="features-box-title font-xeta">Interact</div>
                    <p class="text-muted">
                    You can interact with Xetaravel's members in the {{ link_to(route('blog.article.index'), 'Blog') }}, {{ link_to(route('discuss.index'), 'Discuss') }} or directly with me via the {{ link_to(route('page.contact'), 'Contact') }} page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-terminal pb-5">
    <figure class="mb-0">
		<svg width="100%" height="150" viewBox="0 0 500 150" preserveAspectRatio="none" style="transform: rotate(180deg);" fill="#FFFFFF">
			<path d="M0,150 L0,40 Q250,150 500,40 L580,150 Z"></path>
		</svg>
	</figure>
    <figure class="svg-line">
        <svg width="820" height="300" viewBox="0 0 820 300" fill="#f7c32e">
            <path d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"></path>
        </svg>
	</figure>
    <figure class="svg-pen">
        <img src="{{ asset('images/figures/svg-pen.svg') }}" alt="SVG Pen">
	</figure>
    <figure class="svg-experiences">
        <img src="{{ asset('images/figures/svg-experiences.svg') }}" alt="SVG Experiences">
    </figure>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="terminal">
                    <div class="terminal-header">
                        <div class="terminal-header-dot">
                            <span class="bg-danger rounded-circle"></span>
                            <span class="bg-warning rounded-circle"></span>
                            <span class="bg-success rounded-circle"></span>
                        </div>
                        <div class="terminal-header-title">terminal</div>
                    </div>

                    <div class="terminal-container">
                        <div class="terminal-container-tabs">
                            <div class="terminal-container-tabs-bash">
                                <img src="{{ asset('images/icons/tab-icon.svg') }}" alt="Tab Icon"> Bash
                            </div>
                            <div class="terminal-container-tabs-empty"></div>
                        </div>
                        <pre class="language-shell"><code class="terminal-container-code language-shell hljs"></code></pre>

                    </div>
                </div>
            </div>

            <div class="col-md-4" style="background-color: #f5f7f9;">
                <div class="text-xs-center">
                    <img class="installation-image" src="{{ asset('images/icons/coding.svg') }}" alt="Tab Icon">
                </div>
                <h2 class="installation-title text-xs-center font-xeta">Install the application quickly !</h2>
                <p class="installation-description">
                    You want to try my website in local ? No problem just follow theses steps and get it ready in seconds !
                </p>
            </div>
        </div>
    </div>
</section>

@if ($article)
<section class="section-latest-article pt-5 pb-5">
    <figure class="svg-ruler">
        <img src="{{ asset('images/figures/svg-ruler.svg') }}" alt="SVG Ruler">
	</figure>
    <figure class="svg-voyage">
        <img src="{{ asset('images/figures/svg-voyage.svg') }}" alt="SVG Voyage">
	</figure>
    <figure class="svg-line">
        <svg width="820" height="300" viewBox="0 0 820 300" fill="#2ebef7">
            <path d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"></path>
        </svg>
	</figure>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <article class="row latest-article">
                    <div class="col-md-4 latest-article-cover">
                        <a href="{{ $article->article_url }}" title="{{ $article->title }}">
                            <img class="latest-article-cover-image" src="{{ $article->article_banner }}" alt="Article Banner">
                        </a>
                    </div>

                    <div class="col-md-8 latest-article-body">
                        <span class="latest-article-body-featured">
                            <img src="{{ asset('images/icons/rocket.svg') }}" alt="Rocket Icon" width="20px" height="20px">
                            Featured
                        </span>
                        <div class="latest-article-body-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item latest-article-body-meta-category" data-toggle="tooltip" title="Category">
                                    <a href="{{ $article->category->category_url }}">
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                        {{ $article->category->title }}
                                    </a>
                                </li>
                                <li class="list-inline-item latest-article-body-meta-time text-muted">
                                    <i class="fa fa-calendar" aria-hidden="true"  data-toggle="tooltip" title="Date"></i>
                                    <time datetime="{{ $article->created_at->format('Y-m-d H:i:s') }}" title="{{ $article->created_at->format('Y-m-d H:i:s') }}" data-toggle="tooltip">
                                        {{ $article->created_at->format('Y-m-d') }}
                                    </time>
                                </li>
                            </ul>
                        </div>

                        <h3 class="latest-article-body-title text-truncate" data-toggle="tooltip" title="{{ $article->title }}">
                            <a href="{{ $article->article_url }}">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <div class="latest-article-body-text">
                            {!! Markdown::convertToHtml(Str::limit($article->content, 200)) !!}
                        </div>

                        <hr/>

                        <div class="latest-article-body-footer">
                            <div class="latest-article-body-footer-author">
                                <img src="{{ asset($article->user->avatar_small) }}" alt="Avatar" height="54px" width="54px">
                                <discuss-user
                                    :user="{{ json_encode([
                                        'avatar_small'=> $article->user->avatar_small,
                                        'profile_url' => $article->user->profile_url,
                                        'full_name' => $article->user->full_name
                                    ]) }}"
                                    :created-at="{{ var_export($article->user->created_at->diffForHumans()) }}"
                                    :last-login="{{ var_export($article->user->last_login->diffForHumans()) }}"
                                    :background-color="{{ var_export($article->user->avatar_primary_color) }}">
                                </discuss-user>
                            </div>
                            <div class="latest-article-body-footer-stats text-muted">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <i class="fa fa-comment" aria-hidden="true"  data-toggle="tooltip" title="Comments"></i>
                                        {{ $article->comment_count }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </div>
</section>
@endif

<section class="section-languages pt-5 pb-5">
    <figure class="svg-atom">
        <img src="{{ asset('images/figures/svg-atom.svg') }}" alt="SVG Atom">
	</figure>
    <figure class="svg-glass-pot2">
        <img src="{{ asset('images/figures/svg-glass-pot2.svg') }}" alt="SVG Glass Pot 2">
	</figure>
    <div class="container">
        <h2 class="text-xs-center font-xeta">
            <img src="{{ asset('images/icons/data-science.svg') }}" alt="Data Science Icon" width="60px" height="60px">
            Used Languages
        </h2>
        <p class="text-xs-center mb-4">
            Here is the list of the languages I used to do this website.
        </p>
        <div class="row languages">
            <div class="col-lg-2 mb-3">
                <div class="language language-php">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/php.svg') }}" alt="PHP Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://www.php.net">
                            PHP
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="language language-blade">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/blade.svg') }}" alt="Blade Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://laravel.com/docs/9.x/blade">
                            Blade
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="language language-sass">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/sass.svg') }}" alt="Sass Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://sass-lang.com/">
                            Sass
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="language language-javascript">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/javascript.svg') }}" alt="JavaScript Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://developer.mozilla.org/fr/docs/Web/JavaScript">
                            JavaScript
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="language language-typescript">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/typescript.svg') }}" alt="TypeScript Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://www.typescriptlang.org/">
                            TypeScript
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="language language-vue">
                    <div class="language-image">
                        <img src="{{ asset('images/languages/vue.svg') }}" alt="Vue Icon" width="55px" height="55px">
                    </div>
                    <div class="language-name">
                        <a href="https://vuejs.org">
                            Vue
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-header-register-login').removeClass('btn-outline-primary').addClass('btn-outline-primary-inverse');
        });
    </script>
    <script type="text/javascript">
    particlesJS('particles', {
        "particles": {
            "number": {
                "value": 60,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 5,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true,
        "config_demo": {
            "hide_card": false,
            "background_color": "#b61924",
            "background_image": "",
            "background_position": "50% 50%",
            "background_repeat": "no-repeat",
            "background_size": "cover"
        }
    });
    </script>
@endpush
