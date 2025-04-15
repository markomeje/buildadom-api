<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return '';
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        abort(responser()->send(JsonResponse::HTTP_UNAUTHORIZED, ['user' => auth()->user()], 'Unauthenticated. Please login.'));
    }
}
