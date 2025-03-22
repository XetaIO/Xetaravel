<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\Session;

class SessionRepository
{
    /**
     * Update the session and save it.
     *
     * @param array $data The data used to update the session.
     * @param Session $session The session to update.
     *
     * @return Session
     */
    public static function update(array $data, Session $session): Session
    {
        $session->method =  $data['method'];
        $session->url =  $data['url'];

        if (isset($data['created_at'])) {
            $session->created_at =  $data['created_at'];
        }

        $session->save();

        return $session;
    }
}
