<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Mail\Contact;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return Factory|\Illuminate\Contracts\View\View|Application|object|View
     */
    public function index()
    {
        $article = BlogArticle::with('category', 'user')
            ->latest()
            ->first();

        return view('page.index', ['article' => $article]);
    }

    /**
     * Display the terms page.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        $this->breadcrumbs->addCrumb(
            '<svg class="w-4 h-4 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 47-92.8 37.1c-21.3 8.5-35.2 29.1-35.2 52c0 56.6 18.9 148 94.2 208.3c-9 4.8-19.3 7.6-30.2 7.6L64 512c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zm39.1 97.7c5.7-2.3 12.1-2.3 17.8 0l120 48C570 277.4 576 286.2 576 296c0 63.3-25.9 168.8-134.8 214.2c-5.9 2.5-12.6 2.5-18.5 0C313.9 464.8 288 359.3 288 296c0-9.8 6-18.6 15.1-22.3l120-48zM527.4 312L432 273.8l0 187.8c68.2-33 91.5-99 95.4-149.7z"></path></svg> Terms',
            route('page.terms')
        );

        return view('page.terms', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function showContact(): View
    {
        $this->breadcrumbs->addCrumb('<i class="fa-regular fa-envelope mr-2"></i> Contact', route('page.contact'));

        return view('page.contact', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Send an E-mail to .
     *
     * @param \Illuminate\Http\Request $request The current request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact(Request $request): RedirectResponse
    {
        $rules = [
            'name' => 'required|min:4|max:30',
            'email' => 'required|email|max:50',
            'message' => 'required|min:10',
        ];

        // Bipass the captcha for the unit testing.
        if (App::environment() !== 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|captcha']);
        }

        Validator::make($request->all(), $rules)->validate();

        $details = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
            'ip' => $request->ip()
        ];

        Mail::to(config('xetaravel.site.contact_email'))->send(new Contact($details));

        return redirect()
           ->route('page.contact')
           ->with('success', 'Thanks for contacting me ! I will answer you as fast as I can !');
    }

    /**
     * Display the banished page.
     *
     * @return \Illuminate\Http\Response
     */
    public function banished()
    {
        if (!Auth::user()->hasRole('banished')) {
            return redirect()
                ->route('page.index');
        }

        return view('page.banished');
    }

    /**
     *  Display my custom page.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutme()
    {
        return view('page.aboutme');
    }
}
