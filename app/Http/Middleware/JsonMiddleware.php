<?php

declare(strict_types=1);

namespace App\Http\Middleware;
use App\Utility\Status;
use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(strtolower($request->headers->get('accept')), ['application/json'])) {
            return responser()->send(Status::HTTP_NOT_IMPLEMENTED, ['headers' => $request->headers], 'Please add `Accept: application/json` header.');
        }

        return $next($request);
    }
}
