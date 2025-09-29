<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ImageController extends Controller
{
    //
    public function getImage($filename)
    {
        // 獲取 public 目錄的絕對路徑
        $publicPath = public_path();

        $path = $publicPath . '/static/img/' . $filename;
        // dd($path);
        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    }
}
