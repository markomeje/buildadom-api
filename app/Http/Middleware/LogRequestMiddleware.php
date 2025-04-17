<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $start_time = microtime(true);
        $response = $next($request);

        $end_time = microtime(true);
        $duration = number_format(($end_time - $start_time) * 1000, 2); // milliseconds

        Log::channel('request')->info('Request completed in ' . $duration . ' ms: ' . $request->method() . ' ' . $request->fullUrl());

        return $response;
    }
}
