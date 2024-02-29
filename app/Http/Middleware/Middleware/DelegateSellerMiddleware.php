<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DelegateSellerMiddleware
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
        if (auth('delegateseller')->check()) {
            return $next($request);
        }
        auth()->guard('delegateseller')->logout();
        return redirect()->route('seller.auth.login');
    }
}
