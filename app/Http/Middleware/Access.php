<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenException;
use Closure;
use Illuminate\Http\Request;

class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $staff = auth($guard)->user();

        $prefix = $request->segment(2);
        if ($prefix == 'dashboard') {
            $prefix = $prefix.'/'.$request->segment(3);
        }
    
        $method = $request->getMethod();
        $action = $request->route()->getActionMethod();

        $role = $staff->role;
        $role_name = array_flip(config('constants.authenticate.roles'))[$role];
        //kiểm tra quyền
        if (isValidPrefix($prefix, $role_name) && isValidAction($prefix, $action, $role_name) && isValidMethod($method, $role_name)) {
            return $next($request);
        }

        throw new ForbiddenException();
    }
}
