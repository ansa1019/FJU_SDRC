<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;

class ApiHelper
{
    public static function sendAuthenticatedRequest($token, $url, $formData)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($url, $formData);
    }

    public static function getAuthenticatedRequest($token, $url)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($url);
    }


    public static function oldeditAuthenticatedRequest($token, $url, $formData, $userid)
    {
        $urlWithUserId = rtrim($url, '/') . '/' . $userid . '/';
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'image',
        ];
    
        // 创建一个请求对象并设置请求头
        $request = Http::withHeaders($headers);
    
        if (isset($formData['user_image']) && $formData['user_image']) {
            // 如果存在 user_image 字段，则将文件添加到请求
            $file = $formData['user_image'];
            
            $request->attach('user_image', $file->getPathname(), $file->getClientOriginalName());

            dd($request);
        }

        // 移除上传文件字段，以免与其他字段冲突
        unset($formData['user_image']);
    
        
        // 添加其他字段到请求
        $response = $request->patch($urlWithUserId, $formData);
    
        // 获取响应

        dd($response);
        return $response;
    }

    public static function editAuthenticatedRequest($token, $url, $formData, $userid)
    {
        $urlWithUserId = rtrim($url, '/') . '/' . $userid . '/';
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patch($urlWithUserId,$formData);
    }


    public static function deleteAuthenticatedRequest($token, $url, $userid)
    {
        $urlWithUserId = rtrim($url, '/') . '/' . $userid . '/';
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete($urlWithUserId);
    }

}