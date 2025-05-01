@extends('layouts.app')
{!! config(['app.title' => 'About Me']) !!}

@push('meta')
  <x-meta title="About Me" description="Welcome to my custom personnal page ! You will find a custom made Curriculum Vitae using CSS & JS with all informations you need to know about me !" />
@endpush

@push('scripts')
    @vite('resources/js/typed.js')
    @vite('resources/js/parallax.js')
    @vite('resources/js/jarallax.js')
    @vite('resources/js/waypoints.js')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        /**
         * Typed
         */
        const typed = document.getElementById('aboutme-typed');
        let typed_strings = typed.dataset.typed;
        typed_strings = typed_strings.split(',');

        new Typed('#aboutme-typed', {
            strings: typed_strings,
            loop: true,
            typeSpeed: 100,
            backSpeed: 50,
            backDelay: 3000
        });

        var scene = document.getElementById('parallax-aboutme');
        var parallaxInstance = new Parallax(scene);

        /**
         *  Skills
         */
        new Waypoint({
            element: document.getElementById('skills'),
            offset: '50%',
            handler: function(direction) {
                const progress = document.getElementsByClassName('progress-bar');

                for (let i = 0; i < progress.length; i++) {
                    progress[i].style.width = progress[i].getAttribute('aria-valuenow') + '%';
                }
            }
        });

        /**
         *  Projetcs
         */
        new Waypoint({
            element: document.getElementById('projects'),
            offset: '50%',
            handler: function(direction) {
                const project = document.getElementsByClassName('project');

                for (let i = 0; i < project.length; i++) {
                    project[i].style.opacity = 1;
                }
            }
        });

        /**
         *  Resume
         */
        new Waypoint({
            element: document.getElementById('resume'),
            offset: '50%',
            handler: function(direction) {
                const items = document.getElementsByClassName('resume-item');

                for (let i = 0; i < items.length; i++) {
                    items[i].style.opacity = 1;
                }
            }
        });

        /**
         *  CV
         */
        new Waypoint({
            element: document.getElementById('cv'),
            offset: '50%',
            handler: function(direction) {
                const items = document.getElementsByClassName('cv-item');

                for (let i = 0; i < items.length; i++) {
                    items[i].style.opacity = 1;
                }
            }
        });
    });
</script>
@endpush

@section('content')
<section class="pt-16 pb-5 jarallax"data-jarallax data-speed="0.2" >
    <div class="jarallax-img" style="background-image: url({{ asset('images/aboutme/cubes-bg.jpg') }});"></div>
    <div class="lg:container mx-auto">
        <div class="grid grid-cols-12 gap-2 mx-3 md:mx-0">
            <div class="col-span-12 md:col-span-5 md:col-start-3 mt-10 md:mt-20 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-bold text-white">Emeric Fevre</h1>
                <h2 class="text-3xl md:text-5xl font-bold text-white">I'm a <span id="aboutme-typed" class="text-primary" data-typed="Web Application Developer, Web Application Designer, Star Citizen Pilot, Geek"></span></h2>
            </div>
            <div class="col-span-12 md:col-span-3">
                <div id="parallax-aboutme" class="relative">
                    <div class="absolute top-0 left-0 w-full h-full" data-depth="0.3"><img class="block w-full" src="{{ asset('images/aboutme/layer01.png') }}" alt="Layer"></div>
                    <div class="absolute top-0 left-0 w-full h-full" style="z-index: 2;" data-depth="0.5"><img class="block w-full" src="{{ asset('images/aboutme/layer02.png') }}" alt="Layer"></div>
                    <div class="absolute top-0 left-0 w-full h-full" data-depth="0.3"><img class="block w-full" src="{{ asset('images/aboutme/layer03.png') }}" alt="Layer"></div>
                    <div class="absolute top-0 left-0 w-full h-full" style="z-index: 3;" data-depth="0.2"><img class="block w-full" src="{{ asset('images/aboutme/layer04.png') }}" alt="Layer"></div>
                    <div class="absolute top-0 left-0 w-full h-full" data-depth="0.25"><img class="block w-full" src="{{ asset('images/aboutme/layer05.png') }}" alt="Layer"></div>
                    <div class="absolute top-0 left-0 w-full h-full" style="z-index: 4;" data-depth="0.35"><img class="block w-full" src="{{ asset('images/aboutme/layer06.png') }}" alt="Layer"></div>
                  </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-32 -mb-[2px]">
    <div class="lg:container mx-auto">
        <div class="grid grid-cols-12 gap-2 mx-3 md:mx-0">
            <div class="col-span-12 md:col-span-4 md:col-start-3">
                <h2 class="text-3xl font-semibold mb-6">Web Development (Software)</h2>
                <ul class="">
                    <li class="flex items-center gap-4 mb-4">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Back-end web applications with frameworks <a class="link link-hover link-primary" href="https://laravel.com" target="_blank">Laravel</a>, <a class="link link-hover link-primary" href="https://symfony.com" target="_blank">Symfony</a> & <a class="link link-hover link-primary" href="https://cakephp.org" target="_blank">CakePHP</a>.</span>
                    </li>
                    <li class="flex items-center gap-4 mb-4">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Front-end web application with frameworks <a class="link link-hover link-primary" href="https://vuejs.org" target="_blank">Vue</a> & <a class="link link-hover link-primary" href="https://angular.io/" target="_blank">Angular</a>. Styling with <a class="link link-hover link-primary" href="https://lesscss.org" target="_blank">LESS</a>, <a class="link link-hover link-primary" href="https://sass-lang.com" target="_blank">SASS</a>, <a class="link link-hover link-primary" href="https://getbootstrap.com/" target="_blank">Bootstrap</a> and <a class="link link-hover link-primary" href="https://tailwindcss.com/" target="_blank">Tailwind</a>.</span>
                    </li>
                    <li class=" flex items-center gap-4 mb-4">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Unit Testing, Git, CI/CD, DevOps</span>
                    </li>
                </ul>
                <h4 class="text-2xl font-semibold mt-6">
                    Tools and Technologies:
                </h4>
                <p>
                    PHP, JS, TS, SASS, Laravel, Symfony, CakePHP, Vue, Angular, MySQL, Photoshop
                </p>
            </div>

            <div class="col-span-12 md:col-span-5 md:col-start-8 py-6 md:py-0">
                <figure class="-mb-2">
                    <img class="mx-auto" src="{{ asset('images/aboutme/whatido.svg') }}" alt="SVG Whatido">
                </figure>
            </div>
        </div>
    </div>
    <figure>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4" fill="#37384d">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section id="skills" class="bg-[color:#37384d] pt-20 text-white" data-aos-id="skills" data-aos="fade-in">
    <div class="lg:container mx-auto pb-28">
        <h2 class="text-4xl uppercase text-center relative before:bg-[color:#cccccc] before:bottom-[1px] before:content-[''] before:block before:h-[1px] before:left-[calc(50%-60px)] before:absolute before:w-[120px] after:bg-primary after:bottom-0 after:content-[''] after:block after:h-[3px] after:left-[calc(50%-20px)] after:absolute after:w-[40px] mb-9">
            Skills
        </h2>
        <div class="grid grid-cols-12 gap-2 mx-3 md:mx-0">
            <div class="col-span-12 md:col-span-5 md:col-start-2">
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        HTML <span class="italic">100%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        CSS <span class="italic">90%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        JavaScript <span class="italic">60%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5 md:col-start-7">
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        PHP <span class="italic">90%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        MySQL <span class="italic">70%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
                <div class="font-semibold text-md uppercase mb-5">
                    <span class="flex justify-between">
                        Laravel <span class="italic">80%</span>
                    </span>
                    <div class="bg-white rounded h-4">
                        <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-primary h-4 transition-all duration-1000 ease-linear" style="width:1px;transition: width .6s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <figure class="pt-36 relative -bottom-1">
        <svg class="fill-base-200 dark:fill-base-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section id="projects" class="mb-10 -mt-48 lg:-mt-72 relative">
    <div class="lg:container mx-auto">
        <h2 class="text-4xl uppercase text-center relative text-white before:bg-[color:#cccccc] before:bottom-[1px] before:content-[''] before:block before:h-[1px] before:left-[calc(50%-60px)] before:absolute before:w-[120px] after:bg-primary after:bottom-0 after:content-[''] after:block after:h-[3px] after:left-[calc(50%-20px)] after:absolute after:w-[40px] mb-9">
            Projects
        </h2>

        <div class="grid grid-cols-12 gap-4 mx-3 lg:mx-0">
            <div class="col-span-12 lg:col-span-5 lg:col-start-2 mb-6">
                <div class="project flex flex-col lg:flex-row items-center bg-base-100 shadow-[0_5px_15px_5px_rgba(0,0,0,0.2)] rounded-md p-5 h-full transition duration-500 ease-in-out opacity-0">
                    <img class="min-w-[140px] p-3" src="{{ asset('images/logo.svg') }}" alt="Xetaravel logo">
                    <div class="ml-5 overflow-hidden">
                        <h3 class="text-3xl text-primary truncate">Xetaravel</h3>
                        <p class="overflow-hidden break-words">
                            Realization of a Blog, Forum (Discuss), Admin Panel open-source with the Laravel framework.<br/>
                            <span class="font-semibold">Source Code: </span><a class="link link-hover link-primary" href="https://github.com/XetaIO/Xetaravel">XetaIO/Xetaravel</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-5 lg:col-start-7 mb-6">
                <div class="project flex flex-col lg:flex-row items-center bg-base-100 shadow-[0_5px_15px_5px_rgba(0,0,0,0.2)] rounded-md p-5 h-full transition duration-500 ease-in-out opacity-0">
                    <img class="w-[140px] p-3" src="{{ asset('images/aboutme/xeta.png') }}" alt="Xeta logo">
                    <div class="ml-5 overflow-hidden">
                        <h3 class="text-3xl font-xetaravel text-primary truncate">Xeta</h3>
                        <p class="overflow-hidden break-words">
                            Realization of a Blog, Admin Panel open-source with the CakePHP framework.<br/>
                            <span class="font-semibold">Source Code: </span><a class="link link-hover link-primary" href="https://github.com/XetaIO/Xeta">XetaIO/Xeta</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-5 lg:col-start-2 mb-6">
                <div class="project flex flex-col lg:flex-row items-center bg-base-100 shadow-[0_5px_15px_5px_rgba(0,0,0,0.2)] rounded-md p-5 h-full transition duration-700 ease-in-out opacity-0">
                    <img class="w-[140px] p-3" src="{{ asset('images/aboutme/fmt.png') }}" alt="FrenchModdingTeam logo">
                    <div class="ml-5 overflow-hidden">
                        <h3 class="text-3xl font-xetaravel text-primary truncate">FrenchModdingTeam</h3>
                        <p class="overflow-hidden break-words">
                            Realization of a e-commerce for selling applications connected with the website via a secure API with the CakePHP framework.<br/>
                            <span class="font-semibold">Site : </span><a class="link link-hover link-primary" href="https://www.frenchmoddingteam.com">https://www.frenchmoddingteam.com</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-5 lg:col-start-7 mb-6">
                <div class="project flex flex-col lg:flex-row items-center bg-base-100 shadow-[0_5px_15px_5px_rgba(0,0,0,0.2)] rounded-md p-5 h-full transition duration-700 ease-in-out opacity-0">
                    <img class="w-[140px] p-3" src="{{ asset('images/aboutme/division.png') }}" alt="FrenchModdingTeam logo">
                    <div class="ml-5 overflow-hidden">
                        <h3 class="text-3xl font-xetaravel text-primary truncate">ARK Division</h3>
                        <p class="overflow-hidden break-words">
                            Realization of a donation system with members account, serveurs status update with the Laravel framework.<br/>
                            <span class="font-semibold">Site : </span><a class="link link-hover link-primary" href="https://discuss.ark-division.fr">https://discuss.ark-division.fr</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-10 lg:col-start-2 mb-6">
                <div class="project flex flex-col lg:flex-row items-center bg-base-100 shadow-[0_5px_15px_5px_rgba(0,0,0,0.2)] rounded-md p-5 h-full transition duration-700 ease-in-out opacity-0">
                    <img class="w-[140px] p-3" src="{{ asset('images/aboutme/selvah.png') }}" alt="Selvah logo">
                    <div class="ml-5 overflow-hidden">
                        <h3 class="text-3xl font-xetaravel text-primary truncate">Selvah</h3>
                        <p class="overflow-hidden break-words">
                            Designed, developed and sold a custom web application for managing spare parts and equipment with the Laravel framework.<br/>
                            Included features for planning management, maintenance and incident tracking, and user/permission control.<br/>
                            Built with a focus on improving operational efficiency and centralizing resource management.<br/>
                            Build with TALL stack : Tailwind, Alpine.js, Laravel, Livewire.<br/>
                            <span class="font-semibold">Site : Confidential</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-resume jarallax pt-16 mb-6" data-jarallax data-speed="0.2" >
    <div class="jarallax-img" style="background-image: url({{ asset('images/aboutme/cubes-bg.jpg') }});"></div>
    <div class="lg:container mx-auto">
        <h2 class="text-4xl uppercase font-xetaravel text-center relative text-white before:bg-[color:#cccccc] before:bottom-[1px] before:content-[''] before:block before:h-[1px] before:left-[calc(50%-60px)] before:absolute before:w-[120px] after:bg-primary after:bottom-0 after:content-[''] after:block after:h-[3px] after:left-[calc(50%-20px)] after:absolute after:w-[40px] mb-9">
            Resume
        </h2>

        <div id="resume" class="grid grid-cols-12 gap-4 mx-3 lg:mx-0 text-white">
            <div class="col-span-12 lg:col-span-6">
                <h3 class="text-3xl font-bold mb-4 mt-4">Summary</h3>
                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none">Emeric Fevre</h4>
                    <p class="mb-4">
                        <em>
                            Web Application Developer & Designer, learning since 10+ years in autodidact.
                            Mainly back-end developer with PHP and the frameworks Laravel, Symfony & CakePHP.
                            I have also worked/work with JavaScript, TypeScript, SASS, VueJS, WebPack, Redis, ViteJS, Livewire...
                            I like to work with TALL (Tailwind, Alpine.js, Laravel, Livewire) stack.
                        </em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li>St Marcel, 71380</li>
                        <li>
                            <a class="link link-hover link-primary" href="mailto:{{ config('xetaravel.site.contact_email') }}">{{ config('xetaravel.site.contact_email') }}</a>
                        </li>
                    </ul>
                </div>

                <h3 class="text-3xl font-bold mb-4 mt-4">Education</h3>
                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Professional Certification Level 5  Developer & Integrator Web</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2022</span>
                    <p>
                        <em>Online formation with <a class="link link-hover link-primary" href="https://openclassrooms.com">OpenClassRoom</a>.</em>
                    </p>
                </div>
                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Professional Certification Level 4 Carpenter</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2007</span>
                    <p>
                        <em>Obtained at the CFA <a class="link link-hover link-primary" href="https://www.compagnons-du-devoir.com">Compagnons du Devoir</a> at Dijon.</em>
                    </p>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <h3 class="text-3xl font-bold mb-4 mt-4">Professional Experience</h3>
                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Full-stack Developer & Network Administrator</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2020 - 2023</span>
                    <p>
                        <em>Volunteer at the association <a class="link link-hover link-primary" href="https://ark-division.fr">Division Gaming France</a> (RNA : W863010817).</em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li>
                            Creation of a member section (with account management), donation system (Paypal API) & administration panel with the Laravel framework.
                        </li>
                        <li>
                            Creation of an application for managing the status of the game servers and players connected, with schedule tasks (CRON), and persistence of datas with MySQL.
                        </li>
                        <li>
                            Creation of an automated rewards system for donations, and collecting rewards directly in the game.
                        </li>
                        <li>
                            Continuous Integration with GitHub and GitHub actions, Unit Tests with PHPUnit, Continuous Deployment with Laravel Forge.
                        </li>
                    </ul>
                </div>
                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Full-stack Developer</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2016 - Present</span>
                    <p>
                        <em>Autodidact</em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li>
                            Creation of my personal website with the Laravel framework : <a class="link link-hover link-primary" href="https://xetaravel.com">https://xetaravel.com</a>.
                        </li>
                        <li>
                            Creation of a Discuss forum with <a class="link link-hover link-primary" href="https://github.com/XetaIO/Xetaravel#features">many features</a> (<a class="link link-hover link-primary" href="https://xetaravel.com/discuss">see it in live</a>):
                            <ul class="list-disc pl-10">
                                <li>
                                    Categories
                                </li>
                                <li>
                                    Replies
                                </li>
                                <li>
                                    Leaderboard
                                </li>
                                <li>
                                    Solved Reply
                                </li>
                                <li>
                                    Actions Logs
                                </li>
                                <li>
                                    Pinned/Locked
                                </li>
                            </ul>
                        </li>
                        <li>
                            Creation of many Laravel and CakePHP plugins open-source. You can see them <a class="link link-hover link-primary" href="https://github.com/XetaIO">here</a> and <a class="link link-hover link-primary" href="https://github.com/Xety?tab=repositories">there</a>.
                        </li>
                    </ul>

                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2024</span>
                    <p>
                        <em>Professional Project - Selvah</em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li class="font-bold">
                            Designed and sold a custom web application to my current company for managing spare parts and equipment.
                        </li>
                        <li>
                            Included features for planning management, maintenance and incident tracking, and user/permission control.
                        </li>
                        <li>
                            Built with a focus on improving operational efficiency and centralizing resource management.
                        </li>
                    </ul>
                </div>

                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Deputy Production Manager</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2023 - Present</span>
                    <p>
                        <em>Unlimited Duration Contract - Selvah</em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li>
                            Promoted after joining as a Production Line Operator in 2018.
                        </li>
                        <li>
                            Supervise and coordinate a team to ensure efficient production operations.
                        </li>
                        <li>
                            Develop and manage daily and weekly production schedules.
                        </li>
                        <li>
                            Oversee truck dispatching and logistics.
                        </li>
                        <li>
                            Handle spare parts inventory and ensure availability of critical components.
                        </li>
                        <li>
                            Conduct onboarding and training of new employees.
                        </li>
                    </ul>
                </div>

                <div class="resume-item transition duration-500 ease-in-out opacity-0 relative pl-5 pb-5 -mt-[2px] border-l-2 border-solid border-primary before:bg-[color:#37384d] before:border-2 before:border-solid before:border-primary before:rounded-full before:content[''] before:h-4 before:w-4 before:absolute before:-left-[9px] before:top-0">
                    <h4 class="uppercase text-lg font-semibold text-primary leading-none mb-2">Production Line Operator</h4>
                    <span class="bg-[color:rgba(247,248,249,.1)] rounded inline-block font-semibold px-1 mb-2">2018 - 2023</span>
                    <p>
                        <em>Unlimited Duration Contract - Selvah</em>
                    </p>
                    <ul class="list-disc pl-10">
                        <li>
                            Operated and monitored production line equipment.
                        </li>
                        <li>
                            Ensured compliance with quality and safety standards.
                        </li>
                        <li>
                            Contributed to process improvement initiatives and supported team efficiency.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <figure class="relative -bottom-1">
        <svg class="fill-base-200 dark:fill-base-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section class="section-cv mb-4 relative mt-[2px]">
    <div class="lg:container mx-auto">
        <h2 class="text-4xl uppercase font-xetaravel text-center relative before:bg-[color:#cccccc] before:bottom-[1px] before:content-[''] before:block before:h-[1px] before:left-[calc(50%-60px)] before:absolute before:w-[120px] after:bg-primary after:bottom-0 after:content-[''] after:block after:h-[3px] after:left-[calc(50%-20px)] after:absolute after:w-[40px] mb-9">
            Contact
        </h2>

        <div id="cv" class="grid grid-cols-12 gap-4 items-center text-center mx-3 lg:mx-0">
            <div class="col-span-12 lg:col-span-4 lg:col-start-3 cv-item transition duration-500 ease-in-out opacity-0">
                <h3 class="text-2xl font-semibold mb-6">
                    Curriculum Vitae
                </h3>
                <x-button link="{{ route('downloads.show', 'Fevre_Emeric_CV.pdf') }}" class="btn-primary btn-lg mb-9" label="Download CV" icon="fas-cloud-arrow-down" />

                <h3 class="text-2xl font-semibold mb-6">
                    Contact Me
                </h3>
                <x-button link="mailto:{{ config('xetaravel.site.contact_email') }}" class="btn-primary btn-lg mb-9" label="Contact" icon="fas-paper-plane" />
            </div>
            <div class="col-span-12 lg:col-span-5 lg:col-start-7 cv-item transition duration-500 ease-in-out opacity-0">
                <figure>
                    <img class="mx-auto" src="{{ asset('images/aboutme/cv.svg') }}" alt="SVG CV">
                </figure>
            </div>
        </div>
    </div>
</section>

@endsection
