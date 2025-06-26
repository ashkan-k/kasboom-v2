<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $currentUserLogin = auth()->user()->id;# ->UserLogins->where('id', '=', Session::get('userLoginId'))->first();
            if ($currentUserLogin) {
                return $next($request);
            } else {
                \Illuminate\Support\Facades\Auth::logout();
                return redirect("/login");
            }
        } else {
            return redirect("/login");
        }
    }
}
