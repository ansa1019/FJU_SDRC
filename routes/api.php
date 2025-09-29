<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'AuthController@login');
// Route::post('/submit-form', function () {
//     // 获取表单数据
//     $formData = request()->all();
//     dd($formData);
    
//     // 将表单数据发送到外部 JWT API，这里禁用了 CSRF 保护
//     $response = Http::withoutMiddleware(['csrf'])->post('http://122.116.201.46:8000/api/auth/token/', $formData);
//     dd($response);
    
//     // 处理外部 API 的响应
//     return $response->json();
// });