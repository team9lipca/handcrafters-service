<?php

namespace App\Http\Middleware;

class CorsMiddleware {
    public function handle($request, \Closure $next)
    {
        /*if ($request->getMethod() === "OPTIONS") {
            return response('')
                ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
                ->header('Access-Control-Allow-Origin', '*');
        }

        $response = $next($request);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');*/

        if ($request->getMethod() === "OPTIONS") {
            $response = response('');
        }
        else {
            $response = $next($request);
        }

        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');

        return $response;
    }
}