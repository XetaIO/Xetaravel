<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request ;
use Xetaravel\Models\Newsletter;
use Xetaravel\Models\Repositories\NewsletterRepository;
use Xetaravel\Models\Validators\NewsletterValidator;

class NewsletterController extends Controller
{
    /**
     * Subscribe to the Newsletter
     *
     * @param Request $request The request object.
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        NewsletterValidator::create($request->all())->validate();
        NewsletterRepository::create($request->all());

        return back()
            ->success('You have successfully subscribed to our Newsletter !');
    }

    /**
     * Unsubscribe to the Newsletter.
     *
     * @param string $email The email that should be used to unsubscribe to the Newsletter.
     *
     * @return RedirectResponse
     */
    public function delete(string $email): RedirectResponse
    {
        $newsletter = Newsletter::where('email', $email)->first();

        if ($newsletter && $newsletter->delete()) {
            return back()
                ->success('You have successfully unsubscribed to the Newsletter !');
        }

        return back()
            ->error('An error occurred while unsubscribed to the Newsletter !');
    }
}
