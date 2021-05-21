<?php

namespace App\Session;

use Illuminate\Session\SessionManager as IlluminateSessionManager;
use App\Session\Store;

class SessionManager extends IlluminateSessionManager
{
    /**
     * @override
     * Build the session instance.
     *
     * @see Illuminate\Session\SessionManager::buildSession()
     * @param  \SessionHandlerInterface  $handler
     * @return \Illuminate\Session\Store
     */
    protected function buildSession($handler)
    {
        return $this->config->get('session.encrypt')
                ? $this->buildEncryptedSession($handler)
                : new Store($this->config->get('session.cookie'), $handler);
    }
}
