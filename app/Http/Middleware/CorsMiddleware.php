<?php

namespace App\Http\Middleware;

class CorsMiddleware {
    public function handle($request, \Closure $next)
    {
        if ($request->getMethod() === "OPTIONS") {
            return response('');
        }

        $response = $next($request);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    }
}