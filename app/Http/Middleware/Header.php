<?php
/*
 * @Author: 公共header设置
 * @Date: 2019-12-03 19:03:22
 * @LastEditTime: 2019-12-03 11:37:56
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Header
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
        $user = Auth::guard('api')->user();
        $isAuthorize = (empty($user['avatar_url']) || empty($user['openid'])) ? 0 : 1;
        $isCollege  = empty($user['college_id']) ? 0 : $user['college_id'];
        // header('Bind-Mobile:'.$bindMobile); // 定义title
        header('Is-Authorize:'.$isAuthorize); 
        header('Is-College:'.$isCollege);
        header('Access-Control-Expose-Headers:Is-Authorize,Is-College');
        return $next($request);
    }
}


