<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->method() === 'OPTIONS') {
            return Cors::addCorsHeaders(response('No Content', 204));
        }

        $response = $next($request);
        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers' => 'Accept, Accept-Language, Authorization, User-Agent, Connection, Cache-Control, Content-Type, Content-Language, Range',
            'Access-Control-Expose-Headers' => '*'
        ];


        if ($response instanceof $IlluminateResponse) {
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        if ($response instanceof $SymfonyResopnse) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
            return $response;
        }

        return $response;
    }

    public static function addCorsHeaders($response)
    {
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, OPTIONS, DELETE')
            ->header('Access-Control-Allow-Headers', 'Accept, Accept-Language, Authorization, User-Agent, Connection, Cache-Control, Content-Type, Content-Language, Range')
            ->header('Access-Control-Expose-Headers', '*');
    }
}
