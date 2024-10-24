<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        // 檢查驗證碼是否有效（假設你有儲存驗證碼）
        if ($request->input('verification_code') !== session('verification_code')) {
            return response()->json(['success' => false, 'message' => '驗證碼無效'], 400);
        }

        // 驗證新密碼輸入
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // 查找用戶
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => '用戶不存在'], 404);
        }

        // 更新密碼
        $user->forceFill([
            'password' => Hash::make($request->input('new_password')),
        ])->setRememberToken(Str::random(60));

        $user->save();

        // 密碼重設事件
        event(new PasswordReset($user));

        // 移除已使用的驗證碼
        session()->forget('verification_code');

        return response()->json(['success' => true, 'message' => '密碼已更新成功']);
    }
}
