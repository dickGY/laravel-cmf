<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class AdminMenuRouteCheck
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
        $route = $request->getRequestUri();

        if(cmf_role_id() != 1){
            $routes = DB::table('auth_access')->where(['role_id'=>cmf_role_id(),'rule_route'=>$route])->first();
            if(empty($routes)){
                abort(503, '该功能未为您开启，您暂时不能使用，如有需求，请联系超级管理员。');
            }
        }
        return $next($request);
    }
}
