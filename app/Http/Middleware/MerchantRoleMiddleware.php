<?php

declare(strict_types=1);

namespace App\Http\Middleware;
use App\Enums\User\UserRoleEnum;
use App\Utility\Status;
use Closure;
use Illuminate\Http\Request;

class MerchantRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = auth()->user()->roles->pluck('name')->toArray();
        if (!in_array(strtolower(UserRoleEnum::MERCHANT->value), $roles)) {
            return responser()->send(Status::HTTP_UNAUTHORIZED, null, 'Operation not allowed. Unauthorized entry');
        }

        return $next($request);
    }
}
