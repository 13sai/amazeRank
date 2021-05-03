<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    private $miniProgram;

    public function __construct()
    {
        $this->miniProgram = \EasyWeChat::miniProgram();
    }

    public function doLogin(Request $request)
    {
        if (config('app.env') != 'test') {
            return 'error';
        }

        $userModel = User::where(['id' => $request->input('id')])->first();
        $userModel['meta'] = $this->getUserMetaInfo($userModel);
        return $this->success($userModel);
    }

    public function saveUserInfo(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->failure('', '参数错误');
        }
        $code = request('code', '');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userLoginInfo = $this->miniProgram->auth->session($code);
        if (empty($userLoginInfo['session_key'])) {
            throw new ApiException('请重新进入小程序');
        }
        $user = [
            'session_key' => $userLoginInfo['session_key'],
            'openid' => $userLoginInfo['openid'],
            'unionid' => $userInfo['unionId'] ?? '',
        ];
        if (!$userModel = User::where(['openid' => $userLoginInfo['openid']])->first()) {
            try {
                $userModel = User::create($user);
            } catch (\Throwable $t) {
                throw new ApiException('请重新打开小程序或下拉刷新');
            }
        } else {
            User::where(['openid' => $user['openid']])->update($user);
        }

        $userModel['meta'] = $this->getUserMetaInfo($userModel);
        return $this->success($userModel);
    }

    public function issueToken(Request $request)
    {
        $rules = [
            'iv' => 'required',
            'encryptedData' => 'required'
        ];
        $validator = Validator::make($param = $request->all(), $rules);
        if ($validator->fails()) {
            return $this->failure('', current($validator->errors()->all()));
        }
        $encryptedData = $param['encryptedData'];
        $iv = $param['iv'];
        $sessionKey = $this->user()->session_key??'';
        if (empty($sessionKey)) {
            throw new ApiException('亲，您的登录信息已失效，请重新进入小程序或下拉刷新');
        }

        try {
            $userInfo = $this->miniProgram->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        } catch (DecryptException $e) {
            throw new ApiException('亲，请重新进入或下拉刷新');
        }

        $user = [
            'nickname' => $userInfo['nickName'],
            'gender' => $userInfo['gender'],
            'openid' => $userInfo['openId'],
            'avatar_url' => $userInfo['avatarUrl'],
            'city' => $userInfo['city'],
            'country' => $userInfo['country'],
            'province' => $userInfo['province'],
            'unionid' => $userInfo['unionId'] ?? '',
            'session_key' => $sessionKey,
        ];

        $userRow = User::where(['openid' => $userInfo['openId']])->first();

        if (!$userRow) {
            $userModel = User::create($user);
        } else {
            User::where(['openid' => $userInfo['openId']])->update($user);
            $userModel = User::where(['openid' => $userInfo['openId']])->first();
        }

        $userModel['meta'] = $this->getUserMetaInfo($userModel);
        return $this->success($userModel);
    }

    protected function getUserMetaInfo($user)
    {
        $token = Auth::guard('api')->fromUser($user);
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60 + time(),
        ];
    }

    /**
     * 绑定微信手机
     *
     * @param Request $request
     * @return void
     * @throws ApiException
     */
    public function bindWeChatMobile(Request $request){
        $iv = $request->input('iv');
        $encryptedData = $request->input('encryptedData');

        if (empty($iv) || empty($encryptedData)) {
            Log::channel('error')->alert('参数错误',$request->all());
            throw new ApiException('参数错误');
        }
        $userId = $this->getUserId();
        $sessionKey = User::where('id', $userId)->first()->session_key ?? '';
        if (empty($sessionKey)) {
            throw new UnauthorizedHttpException('code错误，重新登录');
        }
        try {
            $decryptedData = $this->miniProgram->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        } catch (\Throwable $t) {
            throw new ApiException('亲，数据获取失败，请扫码打开小程序');
        }

        if (empty($decryptedData['purePhoneNumber'])) {
            throw new ApiException('参数错误，解密失败');
        }
        $update = [
            'mobile' => $decryptedData['countryCode'].$decryptedData['purePhoneNumber']
        ];

        User::where('id', $userId)->update($update);

        return $this->success();
    }
}
