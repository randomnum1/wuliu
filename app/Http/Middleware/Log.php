<?php

namespace App\Http\Middleware;

use Closure;

use \App\Events\QueryExecuted;

class Log
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
        $response = $next($request);

        //调用事件QueryExecuted，记录日志
        event(new QueryExecuted($request));
        return $response;
    }

}
