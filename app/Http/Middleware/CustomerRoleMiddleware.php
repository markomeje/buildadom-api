<?php

namespace App\Http\Middleware;
use App\Enums\User\UserRoleEnum;
use App\Utility\Responser;
use App\Utility\Status;
use Closure;
use Illuminate\Http\Request;

class CustomerRoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    $roles = auth()->user()->roles->pluck('name')->toArray();
    if(!in_array(strtolower(UserRoleEnum::CUSTOMER->value), $roles)) {
      return responser()->send(Status::HTTP_UNAUTHORIZED, null, 'Operation not allowed. Unauthorized entry');
    }

    return $next($request);
  }
}
