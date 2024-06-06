<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        // return $next($request);

        if ($request->is('login') || $request->is('login/*')) {
            return $next($request);
        }

        if (!Auth::check() || !Session::has('lastActivityTime')) {
            return redirect()->route('login')->with('message', 'セッションがタイムアウトしました。再度ログインしてください。');
        }

        $maxIdleTime = config('session.lifetime') * 60; // セッションの有効期限（秒）

        if (time() - Session::get('lastActivityTime') > $maxIdleTime) {
            Auth::logout();
            return redirect()->route('login')->with('message', 'セッションがタイムアウトしました。再度ログインしてください。');
        }

        Session::put('lastActivityTime', time());
        return $next($request);
    }
}
