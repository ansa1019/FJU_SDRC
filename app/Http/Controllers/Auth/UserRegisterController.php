<?php

namespace App\Http\Controllers\Auth;

use Redirect;
use App\Mail\SendMail;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RouteController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserRegisterController extends Controller
{

    public function someMethod()
    {
        // 获取 JWT 令牌
        $token = Session::get('jwt_token');

        // 请求 URL 和数据
        $url = 'http://example.com/api/endpoint';
        $formData = []; // 填写您的表单数据

        // 发送请求
        $response = ApiHelper::sendAuthenticatedRequest($token, $url, $formData);

        // 处理响应
        if ($response->successful()) {
            // 处理成功的逻辑
        } else {
            // 处理失败的逻辑
        }
    }
    public function CheckNicknameRegister(Request $request)
    {
        $nickname = $request->input('nickname');
    
        // 檢查暱稱是否重複
        $existingUser = DB::table('userprofile_profile')
            ->where('nickname', $nickname)
            ->first();
    
        if ($existingUser) {
            $errorMessage = '此暱稱已經被註冊！';
            return response()->json(['exists' => true, 'error' => $errorMessage]);
        }
    
        return response()->json(['exists' => false]);
    }

    public function JumpUserRegister(Request $request)
    {
        $usermail = $request->input('user_mail');

        // 檢查信箱是否重複
        $existingUser = DB::table('auth_user')
        ->where('username', $usermail)
        ->first();
        // 存在重複信箱
        if ($existingUser) {
            $errorMessage = '此信箱已經被註冊！';
            return redirect('/user_login')->withErrors(['error' => $errorMessage])->with('sidebar', 'None');
        }
        return redirect('/user_register')->with('usermail', $usermail);
    }

    public function UserRegister(Request $request, HttpClient $http)
    {

        $recipientEmail = $request->input('usermail');
        // // 发送邮件
        // Mail::to($recipientEmail)->send(new SendMail());

        // $successMessage = '註冊成功，已發送郵件到您的信箱';

        // return redirect('/')->with('success', $successMessage); // 假设 '/dashboard' 是登录后的页面
        // dd($request->all());

        $csrfToken = csrf_token();
        // 获取表单数据
        // dd($request->all());
        $formData = [
            'token' => $request->input('_token'),
            'usermail' => $request->input('usermail'),
            //信箱
            'user_name' => $request->input('user_name'),
            //真實姓名
            'nickname2' => $request->input('nickname2'),
            // 用戶暱稱
            'gender' => $request->input('gender'),
            // 性別
            'birthday' => $request->input('birthday'),
            //生日
            'age2' => $request->input('age2'),
            //年齡
            'password' => $request->input('password'),
            // 密碼
            'password2' => $request->input('password'),
            //確認密碼
            'height' => $request->input('height'),
            //身高
            'weight' => $request->input("weight"),
            //體重
            'married_state' => $request->input("married_state"),
            //婚姻狀況
            'pregnant_state' => $request->input("pregnant_state"),
            //懷孕狀況
            'birth_plan' => $request->input("birth_plan"),
            //生育計畫
            'disease' => $request->input("disease"),
            //病史
            'other_disease' => $request->input("other_disease"),
            //其他病史
            'allergy_state' => $request->input("allergy_state"),
            //過敏
            'order' => $request->input("order"),
            //醫囑
            'drug' => $request->input("drug"),
            //藥物
            'phone' => $request->input("phone"),
            //電話
            'address' => $request->input("address"),
            //住址
            'today' => $request->input("today"),
            //註冊日期
        ];

        $formRegister = [
            'username' => $formData['usermail'],
            'password' => $formData['password'],
            'password2' => $formData['password2'],
        ];
        $formLogin = [
            'username' => $formData['usermail'],
            'password' => $formData['password'],
        ];

        $formrUserProfile = [
            'user_name' => $formData['user_name'],
            'email' => $formData['usermail'],
            'nickname' => $formData['nickname2'],
            'gender' => $formData['gender'],
            'birthday' => $formData['birthday'],
            'phone' => $formData['phone'],
            'address' => $formData['address'],
        ];

        $formUserbodyProfile = [
            'height' => $formData['height'],
            'weight' => $formData['weight'],
            'family_planning' => $formData['birth_plan'],
            'expecting' => $formData['pregnant_state'],
            'medical_history' => $formData['disease'],
            'other_medical_history' => $formData['other_disease'],
            'medication' => $formData['drug'],
            'doctor_advice' => $formData['order'],
            'allergy' => $formData['allergy_state'],
            'marriage' => $formData['married_state'] == '已婚' ? 1 : 0,
        ];


        //  dd($formrUserProfile);
        //註冊送出
        $response = Http::asForm()->post(env('API_IP') . 'api/auth/register/', $formRegister);
        // dd($request->all());

        // if (!$response->successful()) {
        //     // 打印回應內容以便調試
        //     $responseContent = $response->body();
        //     return redirect('/user_login')->withErrors(['registererror' => '註冊失敗: ' . $responseContent])->with('sidebar', 'None');
        // }


        // 註冊成功
        if ($response->successful()) {
            //登入
            $loginresponse = $http->asForm()->post(env('API_IP') . 'api/auth/token/', $formLogin);

            //登入成功
            if ($loginresponse->successful()) {
                // 登入成功，取得JWT
                $token = $loginresponse->json('access');
                // 将 token 存储在会话中
                Session::put('jwt_token', $token);
                // 新增個資
                $responseprofile = ApiHelper::sendAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/profile/', $formrUserProfile);
                if ($responseprofile->successful()) {
                    // 新增個資成功之後加入身體資料
                    $responsebodyprofile = ApiHelper::sendAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/bodyProfile/', $formUserbodyProfile);
                    if (!$responsebodyprofile->successful()) {
                        // 身體資料新增失敗
                        return redirect('/user_login')->withErrors(['bodyprofileregistererror' => '身體資料新增失敗'])->with('sidebar', 'None');
                    }
                } else {
                    // 個資新增失敗
                    return redirect('/user_login')->withErrors(['profileregistererror' => '個資新增失敗'])->with('sidebar', 'None');
                }
                try {
                    $mail = new SendMail(
                        $request->input('nickname2'), // 用戶暱稱
                        $request->input('birthday'),   // 生日
                        $request->input('height'),     // 身高
                        $request->input('weight'),     // 體重
                        $request->input('age2'),       // 年齡
                        $request->input('pregnant_state'), // 懷孕狀態
                        $request->input('birth_plan'), // 生育計畫
                        $request->input('allergy_state'), // 過敏狀況
                        $request->input('order'),      // 醫囑
                        $request->input('drug'),       // 藥物
                        $request->input('married_state'), // 婚姻狀況
                        $request->input('disease'),    // 疾病
                        $request->input('user_name'),  // 真實姓名
                        $request->input('today')  // 註冊日期
                    );
                    // 發送郵件
                    Mail::to($recipientEmail)->send($mail);
                    $successMessage = '註冊成功，已發送郵件到您的信箱';
                    // 重定向到登录后的页面或返回成功响应
                    return redirect()->route('user_login')->with('successful', $successMessage);
                } catch (\Exception $e) {
                    dd($e->getMessage()); // 用於調試
                    $warningMessage = '發送郵件失敗: ' . $e->getMessage();
                    return back()->withErrors(['mailerror' => $warningMessage])->with('sidebar', 'None');
                }
                
            } else {
                // 登入失敗，打印回應內容以便調試
                $loginResponseContent = $loginresponse->body();
                return redirect('/user_login')->withErrors(['loginerror' => '登入失敗: ' . $loginResponseContent])->with('sidebar', 'None');
            }
        }
        // dd($response->body());
        // 註冊失败，重定向回登录页面或返回错误响应
        $warningMessage = '註冊失敗';
        
        return redirect('/user_login')->withErrors(['registererror' => $warningMessage])->with('sidebar', 'None');
}
}
