<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * A middle to handle Ajax requests.
 * The request must come from an ajax call and the user must be authenticated.
 * If not ajax a 404 error is returned.
 */
class Ajax extends Middleware
{

    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(!$request->ajax()){
            abort(404);
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(403);
    }
}
