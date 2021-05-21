<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\SessionServiceProvider as IlluminateSessionServiceProvider;
use App\Session\SessionManager;

class SessionServiceProvider extends IlluminateSessionServiceProvider
{
    /**
     * @override
     * Register the session manager instance.
     *
     * @see Illuminate\Session\SessionServiceProvider::registerSessionManager()
     * @return void
     */
    protected function registerSessionManager()
    {
        $this->app->singleton('session', function ($app) {
            return new SessionManager($app);
        });
    }
}
