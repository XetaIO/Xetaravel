<?php
namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\Newsletter;

class NewsletterRepository
{
    /**
     * Create a new newsletter and save it.
     *
     * @param array $data The data used to create the newsletter.
     *
     * @return \Xetaravel\Models\Newsletter
     */
    public static function create(array $data): Newsletter
    {
        return Newsletter::create([
            'email' => $data['email'],
            'options' => [
                'articles' => true
            ]
        ]);
    }
}
