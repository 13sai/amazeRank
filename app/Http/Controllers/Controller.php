<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $header = [];

    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    public function format($data = [], $message = '请求成功', $logicCode = 0, $status = 'success')
    {
        $data = [
            'status' => $status,
            'code' => $logicCode,
            'msg' => $message,
            'data' => $data,
        ];
        return Response::json($data, 200, $this->header);
    }

    public function success($data = [], $message = '请求成功')
    {
        return $this->format($data, $message);
    }


    public function failure($data = [], $message = '请求失败', $logicCode = 1, $status = 'failure')
    {
        return $this->format($data, $message, $logicCode, $status);
    }

    protected function user()
    {
        $user = auth('api')->user();
        if ($user) {
            return $user;
        } else {
            throw new UnauthorizedHttpException('jwt-auth', '非法访问 Token not provided');
        }
    }

    public function getUserId()
    {
        try {
            return Auth::guard('api')->id();
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException('jwt-auth', '非法访问 Token not provided');
        }
    }

    public function admin(){
        $user = Auth::guard('admin')->user();
        return $user;
    }

    public function getAdminId(){
        $adminId = Auth::guard('admin')->id();
        return $adminId;
    }

    public function getRole()
    {
        $user = Auth::guard('admin')->user();
        return $user->role;
    }
}
