<?php

namespace App\Http\Middleware;
use App\Utility\Responser;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    if(!in_array(strtolower($request->headers->get('accept')), ['application/json'])) {
      return Responser::send(JsonResponse::HTTP_NOT_IMPLEMENTED, ['headers' => $request->headers], 'Please add `Accept: application/json` header.');
    }

    return $next($request);
  }
}
