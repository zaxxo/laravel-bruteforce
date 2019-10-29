<?php

namespace Zaxxo\LaravelBruteforce;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for bruteforce handling.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class Middleware
{
    /**
     * Throttle request on bruteforce attempt.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  $ident
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $ident = ''): Response
    {
        $ident = $this->getIdent($request, $ident);

        if ($ident) {
            $this->throttle($ident);
        }

        $response = $next($request);

        if ($response instanceof InternalResponse) {
            if ($ident) {
                $this->attempt($ident);
                $this->throttle($ident);
            }

            $response = $response->getResponse();
        }

        return $response;
    }

    /**
     * Register a bruteforce attempt.
     *
     * @param string $ident
     */
    protected function attempt(string $ident): void
    {
        $attempt = new BruteforceAttempt();
        $attempt->ident = $ident;
        $attempt->attempted = Carbon::now();
        $attempt->save();
    }

    /**
     * Throttle request based on the amount of registered bruteforce attempts.
     *
     * @param string $ident
     */
    protected function throttle(string $ident): void
    {
        $offset = BruteforceAttempt::getOffset();

        $attempts = BruteforceAttempt::where('ident', $ident)->where('attempted', '>=', $offset)->count();

        if (!$attempts) {
            return;
        }

        $delay = min(30, 0.1 * pow(2, $attempts));

        usleep($delay * 1000000);
    }

    /**
     * Get current request ident.
     *
     * @param Request $request
     * @param string  $ident
     * @return string
     */
    protected function getIdent(Request $request, string $ident): string
    {
        return md5(sprintf('%s-%s', $request->ip(), $ident));
    }
}
