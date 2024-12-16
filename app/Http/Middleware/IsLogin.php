<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah admin sudah login (session ada)
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');   
        }
        return $next($request);
    }
}


