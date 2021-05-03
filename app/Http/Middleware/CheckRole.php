<?php
/**
 * Author: sai
 * Date: 2020/4/1
 * Time: 16:19
 */

namespace App\Http\Middleware;


use App\Jobs\OperationLogJob;
use Closure;
use Auth;

class CheckRole
{
    /**
     * 处理传入的参数
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($role && strpos($role, Auth::guard('admin')->user()->role) === false) {
            return response()->json(['code' => 401, 'msg' => '你无权操作', 'data' => []]);
        }

        if (!in_array($method = $request->getMethod(), ['GET', 'OPTIONS']) && !in_array($path = $request->getPathInfo(), config('admin.operation_log.except'))) {
            $adminId = Auth::guard('admin')->id();
            $data = [
                'user_id' => $adminId,
                'path' => $path,
                'method' => $method,
                'ip' => $request->getClientIp(),
                'input' => \json_encode($request->all(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
            ];
            $job = (new OperationLogJob($data));
            dispatch($job);
        }

        return $next($request);
    }

}