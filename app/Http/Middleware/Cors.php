<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class Cors
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
        $key = $request->input('key');
        if($key == null){
            return response()->json(["error" => "API key not authorized."]);
        }
        $one = DB::select("SELECT `email` FROM users WHERE `key` = '".$key."'");
        if(!count($one)){
            return response()->json(["error" => "API key not authorized."]);
        }
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
