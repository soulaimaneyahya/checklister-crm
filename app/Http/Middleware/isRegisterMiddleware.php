<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isRegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->payment && auth()->user()->payment->payment_status == "approved") {
            abort(response('Unauthorized', 401));
        }
        return $next($request);
    }
}
