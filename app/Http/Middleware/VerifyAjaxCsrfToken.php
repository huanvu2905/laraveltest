<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;

class VerifyAjaxCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            return true;
        }

        throw new TokenMismatchException('CSRF token mismatch.');
    }

    /**
     * Determine if the session and input CSRF tokens match.
     * @see Illuminate\Foundation\Http\Middleware\VerifyCsrfToken
     *
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $isMatched = parent::tokensMatch($request);

        if (
            $isMatched
            &&
            (! $this->isReading($request))
            &&
            $this->isFormSubmit($request)
        ) {
            $request->session()->forceRegenerateToken();
        }

        return $isMatched;
    }

    /**
     * Determine if the HTTP request is a form-submit request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isFormSubmit($request)
    {
        return $request->has('_token');
    }
}
