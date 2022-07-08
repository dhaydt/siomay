<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $check = session()->get('role');
        if (!$check) {
            Toastr::warning('Tolong login dahulu!');

            return redirect()->route('login');
        }

        if ($check == 1 || $check == 2) {
            return $next($request);
        } else {
            Toastr::warning('Kamu tidak memiliki izin akses!');

            return redirect()->route('login');
        }
    }
}
