<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // 引入基類 Controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        // 驗證輸入參數
        $request->validate([
            'user_email' => 'required|email',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $userEmail = $request->input('user_email');

        // 查找用戶
        $user = User::where('email', $userEmail)->orWhere('username', $userEmail)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => '用戶不存在']);
        }

        // 更新密碼
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => '密碼更新成功']);
    }

}
