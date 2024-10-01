<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class JWTsAuthController extends Controller
{
    public function authenticate(Request $request, HttpClient $http)
    {
        // 表单数据验证
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $usermail = $request->input('username');

        // 檢查信箱是否已存在於資料庫中
        $existingUser = DB::table('auth_user')
            ->where('username', $usermail)
            ->first();

        // 信箱不存在
        if (!$existingUser) {
            $errorMessage = '此帳號尚未註冊！';
            return back()->withErrors(['error' => $errorMessage])->with('sidebar', 'None');
        }

        // 构建表单数据
        $formData = [
            'username' => $request->input('username'),
            //註冊信箱
            'password' => $request->input('password'),
        ];

        // 发送 POST 请求到认证 API
        // dd(env('API_IP'));
        $response = Http::asForm()->post(env('API_IP') . 'api/auth/token/', $formData);

        // 根据 API 响应处理进一步逻辑
        if ($response->successful()) {
            $successMessage = '登入成功!';
            // 认证成功，从响应中获取 JWT token
            $token = $response->json('access');
            // 将 token 存储在会话中
            session_start();
            Session::put('jwt_token', $token);
            Session::put('user_email', $formData['username']);

            $responseProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/profile/')->json();
            $blacklist = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/blacklist/getBlacklist/')->json();
            $notifications = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/notifications/getNotifications/')->json();
            $banlist = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/blacklist/getBanlist/')->json();
            $userNickName = $responseProfile[0]['nickname'];
            $userImage = $responseProfile[0]['user_image'];
            $userGender = $responseProfile[0]['gender'];
            $userID = $responseProfile[0]['id'];
            Session::put('nickname', $userNickName);
            Session::put('gender', $userGender);
            Session::put('blacklist', $blacklist);
            Session::put('notifications', $notifications);
            Session::put('user_image', $userImage);
            Session::put('banlist', $banlist);
            Session::put('is_rd', $responseProfile[0]['is_rd']);
            // dd($responseProfile[0]);

            return redirect('/')->with('successful', $successMessage)->with('sidebar', 'None')->with('userImage', $userImage)->with('userGender', $userGender)->with('userID', $userID)->with('token', $token);

        } elseif ($response->clientError()) {
            // 客户端错误，例如认证失败
            $warningMessage = '登入失敗，請重新檢查帳號密碼';
            return back()->withErrors(['error' => $warningMessage])->with('sidebar', 'None');
        } else {
            // 其他错误，例如服务器错误
            $errorMessage = '伺服器發生錯誤，請稍後再試';
            return back()->withErrors(['error' => $errorMessage])->with('sidebar', 'None');
        }
    }
    public function setUserimage(Request $request)
    {
        Session::put('user_image', $request->user_image);
        return Session::get('user_image');
    }
    public function setBlacklist(Request $request)
    {
        Session::put('blacklist', json_decode($request->blacklist, true));
        return Session::get('blacklist');
    }
    public function setBanlist(Request $request)
    {
        Session::put('banlist', json_decode($request->banlist, true));
        return Session::get('banlist');
    }
    public function setNotifications(Request $request)
    {
        if ($request->has('notifications')) {
            Session::put('notifications', $request->notifications);
            return Session::get('notifications');
        } else {
            Session::forget('notifications');
        }
    }
}