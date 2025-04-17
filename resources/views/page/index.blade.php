@extends('layouts.app')
{!! config(['app.title' => 'Welcome !']) !!}

@push('meta')
  <x-meta title="Welcome !" />
@endpush

@push('scripts')
    @vite('resources/js/typed.js')
    @vite('resources/js/parallax.js')
    @vite('resources/js/highlight.js')
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        const options = {
            strings: ["<span class=\"token comment select-none\" spellcheck=\"true\"><span class=\"hljs-comment\"># Create the project and install librairies</span></span><br/><span class=\"hljs-meta select-none\">&gt;</span><span class=\"select-none\"> $ </span><span class=\"token function\">composer</span> create-project xetaio/xetaravel <span class=\"token operator\">&lt;</span>application_name<span class=\"token operator\">&gt;</span><br/><br/><span class=\"token comment select-none\" spellcheck=\"true\"><span class=\"hljs-comment\"># Run the migration and seed the database</span></span><br/><span class=\"hljs-meta select-none\">&gt;</span><span class=\"select-none\"> $ </span><span class=\"token function\">php</span> artisan migrate<br/><span class=\"hljs-meta select-none\">&gt;</span><span class=\"select-none\"> $ </span><span class=\"token function\">php</span> artisan db:seed<br/><br/><span class=\"token comment select-none\" spellcheck=\"true\"><span class=\"hljs-comment\"># Finally, you need to install and build the JS, CSS and Vue</span></span><br/><span class=\"hljs-meta select-none\">&gt;</span><span class=\"select-none\"> $ </span><span class=\"token function\">npm</span> run install<br/><span class=\"hljs-meta select-none\">&gt;</span><span class=\"select-none\"> $ </span><span class=\"token function\">npm</span> run production"],
            typeSpeed: 40,
            backSpeed: 2,
            backDelay: 50000,
            loop: true,
            showCursor: false,
            contentType: "html"
        };
        new Typed(".terminal-container-code", options);

        const options2 = {
            strings: ["Welcome on <span class=\"text-primary\">Xetaravel</span> !"],
            typeSpeed: 100,
            loop: false,
            showCursor: false,
            contentType: "html"
        };
        new Typed(".xetaravel-typed", options2);

        const scene = document.getElementById("parallax-header");
        const parallaxInstance = new Parallax(scene);

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

        // HighlightJS
        hljs.highlightAll();
    });
</script>
@endpush

@section('content')
<section class="relative bg-gray-800 py-14 overflow-hidden" style="min-height: 465px;">
    <div id="particles" class="absolute top-0 bottom-0 right-0 left-0 pointer-events-none"></div>
    <div class="lg:container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-slate-300">
            <div class="flex flex-col items-center justify-center text-center lg:px-8">
                <h1 class="xetaravel-typed font-bold font-['ubuntu'] text-4xl"></h1>
                <p class="mb-4">
                    This website was made to try <a class="font-bold text-primary" href="https://laravel.com" target="_blank">Laravel</a> and to do my personal website and I have decided to release it to help people starting with <a class="font-bold text-primary" href="https://laravel.com" target="_blank">Laravel</a>.<br/>
                    Project <x-icon name="fas-code" class="h-5 w-5 font-bold inline text-primary"></x-icon> with <x-icon name="fas-coffee" class="h-5 w-5 inline" style="color: #826644"></x-icon> with <a class="font-bold text-primary" href="https://laravel.com" target="_blank">Laravel</a>.
                </p>
                <div>
                    <a class="btn btn-primary btn-primary-shadow" href="{{ route('blog.article.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg> Visit the Blog
                    </a>
                    <a class="btn btn-primary btn-primary-shadow" href="{{ route('discuss.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg> Visit Discuss
                    </a>
                </div>

            </div>
            <div>
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
                        <img src="{{ asset('images/parallax/tailwind.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.4">
                        <img src="{{ asset('images/parallax/javascript.svg') }}" alt="Layer">
                    </div>
                    <div class="parallax-layer" data-depth="0.4">
                        <img src="{{ asset('images/parallax/forge.svg') }}" alt="Layer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative py-20 overflow-hidden">
    <figure class="hidden lg:absolute right-0 top-0 -z-10">
        <img src="{{ asset('images/figures/svg-line.svg') }}" alt="SVG Line">
	</figure>
    <figure class="hidden lg:absolute -bottom-10 -left-20 -z-10">
        <img src="{{ asset('images/figures/svg-glass-pot.svg') }}" alt="SVG Glass Pot">
	</figure>
    <figure class="hidden lg:absolute right-0 top-2/3 lg:top-1/4 -z-10">
        <img src="{{ asset('images/figures/svg-compass.svg') }}" alt="SVG Compass">
	</figure>
    <div class="lg:container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-center">
            <div>
                <img class="h-36 mx-auto" src="{{ asset('images/icons/code.svg') }}" alt="Code Icon">
                <div class="text-2xl">Open Source</div>
                <p class="text-gray-500 dark:text-current">
                    The code source of this website is open source and available on <a href="{{ config('xetaravel.site.github_url') }}" target="_blank" class="text-primary">Github</a>. If you want to contribute, feel free to do a PR.
                </p>
            </div>
            <div>
                <img class="h-36 mx-auto" src="{{ asset('images/icons/experiences.svg') }}" alt="Experiences Icon">
                <div class="text-2xl">Experiences</div>
                <p class="text-gray-500 dark:text-current">
                I use this site for my personal experiences in development, to try new things like JS libraries, or PHP libraries.
                </p>
            </div>
            <div>
                <img class="h-36 mx-auto" src="{{ asset('images/icons/chat.svg') }}" alt="Chat Icon">
                <div class="text-2xl">Interact</div>
                <p class="text-gray-500 dark:text-current">
                You can interact with Xetaravel's members in the <a class="text-primary" href="{{ route('blog.article.index') }}">Blog</a>,<a class="text-primary" href="{{ route('discuss.index') }}">Discuss</a> or directly with me via the <a class="text-primary" href="{{ route('page.contact') }}">Contact</a> page.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="relative py-20 bg-slate-100 overflow-hidden">
    <figure class="hidden lg:absolute left-0 top-1/2">
        <svg width="820" height="300" viewBox="0 0 820 300" fill="#f7c32e">
            <path d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"></path>
        </svg>
	</figure>
    <figure class="hidden lg:absolute left-[10%] top-1/3">
        <img src="{{ asset('images/figures/svg-pen.svg') }}" alt="SVG Pen">
	</figure>
    <figure class="hidden lg:absolute right-0 top-1/3">
        <img src="{{ asset('images/figures/svg-experiences.svg') }}" alt="SVG Experiences">
    </figure>
    <div class="lg:container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 col-span-12 px-3 lg:px-0 overflow-auto">
                <div class="relative bg-[color:#2d333b] text-neutral-content w-full shadow-sm rounded-md">
                    <div class="relative py-3 px-4">
                        <div class="flex">
                            <span class="bg-red-500 h-3 w-3 mr-1 rounded-full"></span>
                            <span class="bg-yellow-500 h-3 w-3 mr-1 rounded-full"></span>
                            <span class="bg-green-500 h-3 w-3 mr-1 rounded-full"></span>
                        </div>
                        <div class="absolute top-[6px] left-0 w-full font-['Cascadia_Mono'] font-bold text-center">terminal</div>
                    </div>

                    <div class="bg-[color:rgba(27,31,35,.6)] border border-solid border-transparent rounded-b-md mb-8 overflow-hidden">
                        <div class="flex bg-[color:rgba(27,31,35,.6)]">
                            <div class="bg-[radial-gradient(136.36%_136.36%_at_50.24%_-36.36%,#3d434c_0,#2d333b_100%)] w-1/5 text-center border-b border-solid border-[color:#1e2127] p-2">
                                <img class="inline-block align-middle" src="{{ asset('images/icons/tab-icon.svg') }}" alt="Tab Icon"> Bash
                            </div>
                            <div class="w-4/5"></div>
                        </div>
                        <pre class="language-shell"><code class="terminal-container-code language-shell hljs bg-[color:#2d333b] text-neutral-content font-['Cascadia_Mono'] h-96 block text-base font-light p-3"></code></pre>

                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 col-span-12 px-3 lg:px-0 text-center">
                <div class="mb-7">
                    <img class="h-36 mx-auto" src="{{ asset('images/icons/coding.svg') }}" alt="Coding Icon">
                </div>
                <h2 class="text-3xl dark:text-slate-600 mb-2">Install the application quickly !</h2>
                <p class="text-xl dark:text-slate-600">
                    You want to try my website in local ? No problem just follow theses steps and get it ready in seconds !
                </p>
            </div>
        </div>
    </div>
</section>

@if ($article)
<section class="relative bg-base-100 dark:bg-base-200 shadow-md py-20 overflow-hidden">
    <figure class="hidden lg:absolute right-[10%] top-1/3 -z-10">
        <img src="{{ asset('images/figures/svg-ruler.svg') }}" alt="SVG Ruler">
	</figure>
    <figure class="hidden lg:absolute left-0 top-1/3 -z-10">
        <img src="{{ asset('images/figures/svg-voyage.svg') }}" alt="SVG Voyage">
	</figure>
    <figure class="hidden lg:absolute right-0 top-1/3 -z-10">
        <svg width="820" height="300" viewBox="0 0 820 300" fill="#2ebef7">
            <path d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"></path>
        </svg>
	</figure>

    <div class="lg:container mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-start-2 col-span-10  lg:col-start-3 lg:col-span-8">
                <article class="rounded-lg lg:rounded-tr-none shadow-[0_2px_20px_5px_rgba(19,16,34,0.1)] dark:bg-base-300 bg-base-content">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 lg:col-span-4 rounded-t-lg lg:rounded-l-lg lg:rounded-r-none min-h-[300px] overflow-hidden">
                            <a class="h-full" href="{{ $article->show_url }}" title="{{ $article->title }}">
                                <img class="object-cover h-full" src="{{ $article->article_banner }}" alt="Article Banner">
                            </a>
                        </div>

                        <div class="col-span-12 lg:col-span-8 flex flex-col justify-evenly min-h-[300px] py-5 px-4 lg:pl-0 relative">
                            <span class="absolute -right-2.5 -top-4 lg:top-1 text-white bg-[color:#f4645f] rounded rounded-tr-none color-white font-bold shadow-md p-1 before:bg-[color:#f4645f] before:content-[''] before:h-[5px] before:absolute before:right-0 before:top-[-4px] before:w-[10px] before:rounded-tr">
                                <img class="inline mr-1" src="{{ asset('images/icons/rocket.svg') }}" alt="Rocket Icon" width="20px" height="20px">
                                Featured
                            </span>
                            <div class="text-slate-300 mb-4">
                                <ul>
                                    <li class="inline bg-[color:#f3f6ff] text-primary text-md font-semibold rounded py-1 px-2.5 tooltip" data-tip="Category">
                                        <a href="{{ $article->category->show_url }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                            </svg>

                                            {{ $article->category->title }}
                                        </a>
                                    </li>
                                    <li class="border-l border-solid border-[color:#e2e5f1] ml-2.5 pl-2.5 tooltip" data-tip="Created at {{ $article->created_at->format('Y-m-d H:i:s') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                        </svg>

                                        <time datetime="{{ $article->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $article->created_at->format('Y-m-d') }}
                                        </time>
                                    </li>
                                </ul>
                            </div>

                            <h3 class="truncate text-3xl text-primary mb-4" title="{{ $article->title }}">
                                <a href="{{ $article->show_url }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <div class="text-slate-300">
                                {!! Markdown::convertToHtml(Str::limit($article->content, 200)) !!}
                            </div>

                            <div class="divider"></div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="avatar mr-2">
                                        <div class="w-12 h-12 rounded-full">
                                            <img src="{{ asset($article->user->avatar_small) }}" alt="{{ $article->user->full_name }} Avatar">
                                        </div>
                                    </div>

                                    <div class="dropdown dropdown-hover dropdown-top dropdown-middle !aspect-auto">
                                        <label tabindex="0" class="text-primary font-bold cursor-pointer">
                                            {{ $article->user->full_name }}
                                        </label>
                                        <div tabindex="0" class="dropdown-content card card-compact shadow bg-base-100 rounded-box min-w-fit">
                                            <div class="card-body flex flex-row">
                                                <div class="avatar">
                                                    <div class="w-24 rounded-full ring ring-[color:#fff]">
                                                        <img src="{{ asset($article->user->avatar_small) }}" alt="{{ $article->user->full_name }} Avatar">
                                                    </div>
                                                </div>
                                                <div class="flex flex-col justify-around  min-w-[250px] ml-2">
                                                    <div class="card-title truncate">
                                                        <a href="{{ $article->user->show_url }}" class="text-primary">{{ $article->user->full_name }}</a>
                                                    </div>
                                                    <ul class="flex">
                                                        <li data-tip="Last seen" class="tooltip">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            {{ $article->user->last_login_date->diffForHumans() }}
                                                        </li>
                                                        <li data-tip="Registered" class="tooltip ml-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"></path></svg>
                                                            {{ $article->user->created_at->diffForHumans() }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="text-slate-300">
                                    <ul>
                                        <li class="tooltip font-bold" data-tip="Comments">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                            </svg>

                                            {{ $article->blog_comment_count }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endif

<section class="relative py-20">
    <figure class="hidden lg:absolute right-[5%] top-1/4 -z-10">
        <img src="{{ asset('images/figures/svg-atom.svg') }}" alt="SVG Atom">
	</figure>
    <figure class="hidden lg:absolute left-[5%] top-2/4 -z-10">
        <img src="{{ asset('images/figures/svg-glass-pot2.svg') }}" alt="SVG Glass Pot 2">
	</figure>
    <div class="lg:container mx-auto">
        <h2 class="text-center text-4xl mb-3">
            <img class="inline-block" src="{{ asset('images/icons/data-science.svg') }}" alt="Data Science Icon" width="60px" height="60px">
            Used Technologies
        </h2>
        <p class="text-center text-xl mb-8">
            Here is the list of the technologies I used to do this website.
        </p>
        <div class="grid grid-cols-12 gap-6 lg:gap-12">
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(79,93,149,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/php.svg') }}" alt="PHP Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#4f5d95] text-2xl font-semibold">
                        <a href="https://www.php.net">
                            PHP
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(255,45,32,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/blade.svg') }}" alt="Blade Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#ff2d20] text-2xl font-semibold">
                        <a href="https://laravel.com/docs/12.x/blade">
                            Blade
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(207,100,154,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/livewire.svg') }}" alt="Sass Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#EE5D99] text-2xl font-semibold">
                        <a href="https://livewire.laravel.com/">
                            Livewire
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(240,219,79,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/javascript.svg') }}" alt="JavaScript Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#f0db4f] text-2xl font-semibold">
                        <a href="https://developer.mozilla.org/fr/docs/Web/JavaScript">
                            JavaScript
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(68,168,179,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/tailwind.svg') }}" alt="TypeScript Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#44a8b3] text-2xl font-semibold">
                        <a href="https://tailwindcss.com/">
                            Tailwind
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12  lg:col-span-2 mx-3 lg:mx-0">
                <div class="flex flex-col justify-center items-center h-full p-2.5 bg-[color:rgba(65,184,131,.2)] rounded-md hover:-translate-y-6 transition-transform">
                    <div class="my-2">
                        <img src="{{ asset('images/languages/vue.svg') }}" alt="Vue Icon" width="65px" height="65px">
                    </div>
                    <div class="my-2 text-[color:#41b883] text-2xl font-semibold">
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
