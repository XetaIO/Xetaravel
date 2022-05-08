<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Xetaravel\Mail\Contact;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::with('category', 'user')
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
        $this->breadcrumbs->addCrumb('Terms', route('page.terms'));

        return view('page.terms', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function showContact(): View
    {
        $this->breadcrumbs->addCrumb('Contact', route('page.contact'));

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
}
