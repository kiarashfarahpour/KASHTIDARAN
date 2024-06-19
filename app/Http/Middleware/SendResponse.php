<?php

namespace App\Http\Middleware;

use Closure;

class SendResponse
{
    /**
     * Send Response
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header('X-Author: vediana.com');
        header('X-Powered-By: Vediana\'s development team');
        return $next($request);
    }
}