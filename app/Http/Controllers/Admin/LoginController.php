<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->failure('', '参数错误');
        }

        $admin = Admin::where('username', $request->get('username'))->first();
        if (!$admin) {
            return $this->failure('', '账号不存在');
        }
        if (Hash::check($request->get('password'), $admin->password)) {
            $admin->token = $admin->api_token;
            return $this->success($admin, '登陆成功');
        } else {
            return $this->failure('');
        }
    }

    public function info()
    {
        $user = $this->admin();

        if (!isset($user->username)) {
            return $this->failure('', '登录失效，请重新登录');
        }

        $data = [
            'avatar' => "https://zlfz-hotel.oss-cn-hangzhou.aliyuncs.com/imgs/logo2.png",
            'introduction' => $user->username,
            'name' => $user->name,
            'debug' => bcrypt('xxn52099'),
            'roles' => [
                $user->role
            ],
        ];

        return $this->success($data);
    }
}
