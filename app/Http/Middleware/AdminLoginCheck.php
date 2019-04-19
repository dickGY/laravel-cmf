<?php

namespace App\Http\Middleware;

use Closure;

class AdminLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!$request->session()->get('admin_id') || !$request->session()->get('role_id')){
            return redirect('admin/login');
        }
        return $next($request);
    }
}
