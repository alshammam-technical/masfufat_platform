<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        if(!Str::contains(request()->url(), 'get-notifications')){
            session()->put('keep_return_url', $request->url());
        }
        return redirect()->route('admin.auth.login');
    }
}
