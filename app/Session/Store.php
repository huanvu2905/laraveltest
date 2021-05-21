<?php

namespace App\Session;

use Illuminate\Session\Store as IlluminateSessionStore;

class Store extends IlluminateSessionStore
{
    /**
     * Force regenerate the CSRF token value.
     *
     * @return void
     */
    public function forceRegenerateToken()
    {
        $this->regenerateToken();

        $this->handler->write($this->getId(), $this->prepareForStorage(
            serialize($this->attributes)
        ));
    }
}
