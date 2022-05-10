@extends('layouts.app')
{!! config(['app.title' => 'About Me']) !!}

@push('meta')
  <x-meta title="About Me" />
@endpush

@push('scripts')
<script src="{{ mix('js/home.min.js') }}"></script>
<script src="{{ mix('js/noframework.waypoints.min.js') }}"></script>
<script type="text/javascript">
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
    let skilsContent = document.getElementById('skills');
    new Waypoint({
        element: skilsContent,
        offset: '80%',
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
    let projects = document.getElementById('projects');
    new Waypoint({
        element: projects,
        offset: '80%',
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
     let resumes = document.getElementById('resume');
    new Waypoint({
        element: resumes,
        offset: '60%',
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
     let cv = document.getElementById('cv');
    new Waypoint({
        element: cv,
        offset: '70%',
        handler: function(direction) {
            const items = document.getElementsByClassName('cv-item');

            for (let i = 0; i < items.length; i++) {
                items[i].style.opacity = 1;
            }
        }
    });

</script>
@endpush

@section('content')
<section class="section-aboutme pt-9 pb-5 jarallax"data-jarallax data-speed="0.2" >
    <div class="jarallax-img" style="background-image: url({{ asset('images/aboutme/cubes-bg.jpg') }});"></div>
    <div class="container">
        <div class="row aboutme">
            <div class="col-lg-6 aboutme-text">
                <h1 class="aboutme-text-title">Emeric Fevre</h1>
                <h2 class="aboutme-text-job">I'm a <span id="aboutme-typed" data-typed="Web Application Developer, Web Application Designer, Star Citizen Pilot, Geek"></span></h2>
            </div>
            <div class="col-lg-5">
                <div id="parallax-aboutme" class="parallax">
                    <div class="parallax-layer position-relative" data-depth="0.3"><img src="{{ asset('images/aboutme/layer01.png') }}" alt="Layer"></div>
                    <div class="parallax-layer" style="z-index: 2;" data-depth="0.5"><img src="{{ asset('images/aboutme/layer02.png') }}" alt="Layer"></div>
                    <div class="parallax-layer" data-depth="0.3"><img src="{{ asset('images/aboutme/layer03.png') }}" alt="Layer"></div>
                    <div class="parallax-layer" style="z-index: 3;" data-depth="0.2"><img src="{{ asset('images/aboutme/layer04.png') }}" alt="Layer"></div>
                    <div class="parallax-layer" data-depth="0.25"><img src="{{ asset('images/aboutme/layer05.png') }}" alt="Layer"></div>
                    <div class="parallax-layer" style="z-index: 4;" data-depth="0.35"><img src="{{ asset('images/aboutme/layer06.png') }}" alt="Layer"></div>
                  </div>
            </div>
        </div>
    </div>
</section>

<section class="section-whatido mt-8">
    <div class="container">
        <div class="row whatido">
            <div class="col-xl-5 col-md-6">
                <h3 class="whatido-title mb-2">Web Development (Software)</h3>
                <ul class="whatido-menu list-unstyled">
                    <li class="whatido-menu-item mb-1">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Back-end web applications with frameworks <a href="https://laravel.com" target="_blank">Laravel</a>, <a href="https://symfony.com" target="_blank">Symfony</a> & <a href="https://cakephp.org" target="_blank">CakePHP</a>.</span>
                    </li>
                    <li class="whatido-menu-item mb-1">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Front-end web application with frameworks <a href="https://vuejs.org" target="_blank">Vue</a> & <a href="https://angular.io/" target="_blank">Angular</a>. Styling with <a href="https://lesscss.org" target="_blank">LESS</a> and <a href="https://sass-lang.com" target="_blank">SASS</a>.</span>
                    </li>
                    <li class="whatido-menu-item mb-1">
                        <img class="mr-1" src="{{ asset('images/aboutme/check.png') }}" alt="Check icon" width="20px" height="20px">
                        <span>Unit Testing, Git, CI/CD, DevOps</span>
                    </li>
                </ul>
                <h4 class="whatido-subtitle mt-2">Tools and Technologies:</h4>
                <p>PHP, JS, TS, SASS, Laravel, Symfony, CakePHP, Vue, Angular, MySQL, Photoshop</p>
            </div>
            <div class="col-xl-6 offset-xl-1 col-md-6">
                <figure class="whatido">
                    <img src="{{ asset('images/aboutme/whatido.svg') }}" alt="SVG Whatido">
                </figure>
            </div>
        </div>
    </div>
    <figure>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4" fill="#f4f3ff">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section class="section-skills pt-5">
    <div class="container pb-7">
        <h2 class="section-aboutme-title font-xeta text-xs-center mb-3">
            Skills
        </h2>
        <div class="row skills" id="skills">
            <div class="col-lg-6">
                <div class="progress">
                    <span class="skill">
                        HTML <i class="val">100%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="progress">
                    <span class="skill">
                        CSS <i class="val">90%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="progress">
                    <span class="skill">
                        JavaScript <i class="val">60%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="progress">
                    <span class="skill">
                        PHP <i class="val">90%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="progress">
                    <span class="skill">
                        MySQL <i class="val">70%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="progress">
                    <span class="skill">
                        Laravel <i class="val">80%</i>
                    </span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <figure class="pt-9">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4" fill="#fff">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section class="section-projects mb-4">
    <div class="container">
        <h2 class="section-aboutme-title font-xeta text-xs-center mb-3">
            Projects
        </h2>
        <div class="row" id="projects">
            <div class="col-lg-6 mb-3">
                <div class="project">
                    <img class="project-image" src="{{ asset('images/logo.svg') }}" width="140" alt="Xetaravel logo">
                    <div class="project-body">
                        <h3 class="project-body-title font-xeta text-primary text-truncate">Xetaravel</h3>
                        <p class="project-body-description">
                            Realization of a Blog, Forum (Discuss), Admin Panel open-source with the Laravel framework.<br/>
                            <span class="">Source Code: </span><a href="https://github.com/XetaIO/Xetaravel">XetaIO/Xetaravel</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="project">
                    <img class="project-image" src="{{ asset('images/aboutme/xeta.png') }}" width="140" alt="Xeta logo">
                    <div class="project-body">
                        <h3 class="project-body-title font-xeta text-primary text-truncate">Xeta</h3>
                        <p class="project-body-description">
                            Realization of a Blog, Admin Panel open-source with the CakePHP framework.<br/>
                            <span class="">Source Code: </span><a href="https://github.com/XetaIO/Xeta">XetaIO/Xeta</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="project delay-4">
                    <img class="project-image" src="{{ asset('images/aboutme/fmt.png') }}" width="140"  alt="FrenchModdingTeam logo">
                    <div class="project-body">
                        <h3 class="project-body-title font-xeta text-primary text-truncate">FrenchModdingTeam</h3>
                        <p class="project-body-description">
                            Realization of a e-commerce for selling applications connected with the website via a secure API with the CakePHP framework.<br/>
                            <span class="">Site : </span><a href="https://www.frenchmoddingteam.com">https://www.frenchmoddingteam.com</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="project delay-4">
                    <img class="project-image" src="{{ asset('images/aboutme/division.png') }}" width="140"  alt="FrenchModdingTeam logo">
                    <div class="project-body">
                        <h3 class="project-body-title font-xeta text-primary text-truncate">ARK Division</h3>
                        <p class="project-body-description">
                            Realization of a donation system with members account, serveurs status update with the Laravel framework.<br/>
                            <span class="">Site : </span><a href="https://discuss.ark-division.fr">https://discuss.ark-division.fr</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-resume jarallax pt-4 mb-6"data-jarallax data-speed="0.2" >
    <div class="jarallax-img" style="background-image: url({{ asset('images/aboutme/cubes-bg.jpg') }});"></div>
    <div class="container">
        <h2 class="section-aboutme-title font-xeta text-xs-center mb-3">
            Resume
        </h2>
        <div class="row resume mb-1" id="resume">
            <div class="col-md-6">
                <h3 class="resume-title mb-1 mt-1">Sumary</h3>
                <div class="resume-item">
                    <h4 class="resume-item-title text-primary">Emeric Fevre</h4>
                    <p>
                        <em>Web Application Developer & Designer, learning since 10+ years in autodidact. Mainly back-end developer with PHP and the frameworks Laravel, Symfony & CakePHP.  I have also worked/work with JavaScript, TypeScript, SASS, VueJS, WebPack, Redis... I’m currently in formation at <a href="https://openclassrooms.com">OpenClassRoom</a>.</em>
                    </p>
                    <ul>
                        <li>St Marcel, 71380</li>
                        <li>
                            <a href="mailto:{{ config('xetaravel.site.contact_email') }}">{{ config('xetaravel.site.contact_email') }}</a>
                        </li>
                    </ul>
                </div>

                <h3 class="resume-title mb-1 mt-1">Education</h3>
                <div class="resume-item">
                    <h4 class="resume-item-title text-primary">Professionnal Certification Level 5  Developer & Integrator Web</h4>
                    <h5 class="resume-item-years">2022</h5>
                    <p>
                        <em>Online formation with <a href="https://openclassrooms.com">OpenClassRoom</a>.</em>
                    </p>
                </div>
                <div class="resume-item">
                    <h4 class="resume-item-title text-primary">Professional Certification Level 4 Carpenter</h4>
                    <h5 class="resume-item-years">2007</h5>
                    <p>
                        <em>Obtained at the CFA <a href="https://www.compagnons-du-devoir.com">Compagnons du Devoir</a> at Dijon.</em>
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="resume-title mb-1 mt-1">Professional Experience</h3>
                <div class="resume-item">
                    <h4 class="resume-item-title text-primary">Full-stack Developer & Network Administrator</h4>
                    <h5 class="resume-item-years">2020 - Present</h5>
                    <p>
                        <em>Volunteer at the association <a href="https://ark-division.fr">Division Gaming France</a> (RNA : W863010817).</em>
                    </p>
                    <ul>
                        <li>
                            Creation of a member section (with account management), donation system (Paypal API) & administration panel with the Laravel framework.
                        </li>
                        <li>
                            Creation of an application for managing the status of the game servers and players connected, with scheldule ()CRON) tasks, and persistence of datas with MySQL.
                        </li>
                        <li>
                            Creation of an automated rewards system for donations, and collecting rewards directly in the game.
                        </li>
                        <li>
                            Continious Integration with GitHub and GitHub actions, Unit Tests with PHPUnit, Continious Deployment with Laravel Forge.
                        </li>
                    </ul>
                </div>
                <div class="resume-item">
                    <h4 class="resume-item-title text-primary">Full-stack Developer</h4>
                    <h5 class="resume-item-years">2016 - Present</h5>
                    <p>
                        <em>Autodidact</em>
                    </p>
                    <ul>
                        <li>
                            Creation of my personnal website with the Laravel framework : <a href="https://xetaravel.com">https://xetaravel.com</a>.
                        </li>
                        <li>
                            Creation of many Laravel and CakePHP plugins open-source.
                        </li>
                        <li>
                            Creation of a Discuss forum with <a href="https://github.com/XetaIO/Xetaravel#features">many features</a> (<a href="https://xetaravel.com/discuss">see it in live</a>):
                            <ul>
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <figure>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4" fill="#fff">
            <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
        </svg>
    </figure>
</section>

<section class="section-cv mb-4">
    <div class="container">
        <h2 class="section-aboutme-title font-xeta text-xs-center mb-3">
            Contact
        </h2>
        <div class="row cv" id="cv">
            <div class="col-xl-5 col-md-6 cv-item">
                <h3 class="cv-title mb-2">Curriculum Vitae</h3>
                {{ link_to(route('downloads.show', 'Fevre_Emeric_CV.pdf'), '<i class="fas fa-arrow-alt-circle-down"></i> Download CV', ['class' => 'btn btn-outline-primary btn-lg mb-2'], null, false) }}

                <h3 class="cv-title mb-2">Contact Me</h3>
                {{ link_to("mailto:" . config('xetaravel.site.contact_email'), '<i class="far fa-paper-plane"></i> Contact', ['class' => 'btn btn-outline-primary btn-lg mb-2'], null, false) }}
            </div>
            <div class="col-xl-6 offset-xl-1 col-md-6 cv-item">
                <figure>
                    <img src="{{ asset('images/aboutme/cv.svg') }}" alt="SVG CV">
                </figure>
            </div>
        </div>
    </div>
</section>

@endsection