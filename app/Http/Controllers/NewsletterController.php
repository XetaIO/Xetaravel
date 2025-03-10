<?php

namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request ;
use Xetaravel\Models\Newsletter;
use Xetaravel\Models\Repositories\NewsletterRepository;
use Xetaravel\Models\Validators\NewsletterValidator;

class NewsletterController extends Controller
{
    /**
     * Subcribe to the Newsletter
     *
     * @param \Illuminate\Http\Request $request The request object.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        NewsletterValidator::create($request->all())->validate();
        NewsletterRepository::create($request->all());

        return back()
            ->with('success', 'You have successfuly subscribed to our Newsletter !');
    }

    /**
     * Unsubcribe to the Newsletter.
     *
     * @param string $email The email that should be used to unsubscribe to the Newsletter.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $email): RedirectResponse
    {
        $newsletter = Newsletter::where('email', $email)->first();

        if ($newsletter && $newsletter->delete()) {
            return back()
                ->with('success', 'You have successfully unsubscribed to the Newsletter !');
        }

        return back()
            ->with('danger', 'An error occurred while unsubscribed to the Newsletter !');
    }
}
