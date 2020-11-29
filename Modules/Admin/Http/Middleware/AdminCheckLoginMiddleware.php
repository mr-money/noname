<?php
/**
 * 检查登录
 */

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $admin_has = $request->session()->has('admin');
        if(!$admin_has){
            redirect('admin/login');
        }
        return $next($request);
    }
}
