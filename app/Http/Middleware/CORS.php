<?php

namespace App\Http\Middleware;

use Closure;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */ 
    // public function handle($request, Closure $next)
    // {

    //     header("Access-Control-Allow-Origin: *");

    //     // ALLOW OPTIONS METHOD
    //     $headers = [
    //         'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
    //         'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
    //     ];
    //     if($request->getMethod() == "OPTIONS") {
    //         // The client-side application can set only headers allowed in Access-Control-Allow-Headers
    //         return Response::make('OK', 200, $headers);
    //     }

    //     $response = $next($request);
    //     foreach($headers as $key => $value)
    //         $response->header($key, $value);
    //     return $response;
    // }

    // public function handle($request, Closure $next)
    // {
		// return $next($request)
		// 	->header('Access-Control-Allow-Origin', '*')
		// 	->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
		// 	->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    // }
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With,X-XSRF-TOKEN'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
          foreach($headers as $key => $value)
        {
            
           $response->headers->set($key,$value);
        }
        
        return $response;
    }
}