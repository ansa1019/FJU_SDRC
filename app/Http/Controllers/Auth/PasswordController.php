<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class PasswordController extends Controller
{
    public function validateOldPassword(Request $request)
    {
        $oldPassword = $request->old_password;
        if (Hash::check($oldPassword, Auth::user()->password)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => '舊密碼不正確']);
        }
    }

    public function updatePassword(Request $request)
    {
        $newPassword = $request->new_password;
        if ($request->new_password == $request->check_password) {
            User::find(Auth::id())->update(['password' => Hash::make($newPassword)]);
            return response()->json(['success' => true, 'message' => '密碼更新成功']);
        } else {
            return response()->json(['success' => false, 'message' => '新密碼和確認密碼不匹配']);
        }
    }
}

