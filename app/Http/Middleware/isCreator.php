<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isCreator
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page!');
        } else {
            if (Auth::user()->role != 'creator') {
                //hangi rolde olursa olsun creator olmayanlar bu sayfaya erişemez, gelen kullanıcıyı önceki sayfaya yönlendirir
                return redirect()->back()->with('error', 'You must be logged in to access this page!');
            }
        }
        return $next($request);
    }
}
