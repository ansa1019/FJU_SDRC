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
        $request->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // 查找用戶
        $user = $request->user();

        // 更新密碼
        $user->forceFill([
            'password' => Hash::make($request->input('new_password')),
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return response()->json(['success' => true, 'message' => '密碼已更新成功']);
    }
}
