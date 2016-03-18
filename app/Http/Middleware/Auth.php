<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Crypt;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $raw = Cookie::get('email');
        if($raw == ""){
            return redirect()->to('/')->withErrors('error', 'Please sign in.');;
        }
        return $next($request);
    }
}
