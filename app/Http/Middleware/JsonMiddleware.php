<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

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
      return response()->json([
        'status' => false,
        'message' => 'Please add `Accept: application/json` header.'
      ], 501);
    }

    return $next($request);
  }
}
