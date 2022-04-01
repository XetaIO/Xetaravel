<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $articles = Article::with('category', 'user')
            ->latest()
            ->limit(6)
            ->get();

        $comments = Comment::with('user')
            ->whereHas('article', function ($query) {
                $query->where('is_display', true);
            })
            ->latest()
            ->limit(4)
            ->get();

        return view('page.index', ['articles' => $articles, 'comments' => $comments]);
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
