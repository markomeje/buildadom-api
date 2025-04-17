<?php

namespace App\Http\Middleware;
use App\Utility\Status;
use Closure;
use Illuminate\Http\Request;

class PaystackIpWhitelist
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $whitelist = [
            '52.31.139.75',
            '52.49.173.169',
            '52.214.14.220',
        ];

        if (in_array($request->ip(), $whitelist)) {
            return $next($request);
        }

        return responser()->send(Status::HTTP_UNAUTHORIZED, null, 'Operation not allowed. Unauthorized entry');
    }
}
