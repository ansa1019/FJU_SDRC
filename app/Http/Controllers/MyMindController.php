<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MyMindController extends Controller
{
    public function myMindView()
    {
        $token = Session::get('jwt_token', '');
        $subcategorys = Http::asForm()->get(env('API_IP') . 'api/content/subcategory/')->json();

        if ($token != '') {
            // 獲取文章數據
            $myMindResponse = ['articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/userGetSelfPost/')->json()];
            $postStoraged = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();

            // 判斷收藏是否為空，若是則新增 "不分類收藏"
            if ($token != '' && $postStoraged == []) {
                $formdata = [
                    'storage_name' => '不分類收藏',
                ];

                $addpostStoraged = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            }

            // 處理每篇文章數據
            foreach ($myMindResponse['articles'] as $key => $article) {
                $myMindResponse['articles'][$key]['comment_count'] = count($article['comments']);
                $myMindResponse['articles'][$key]['title'] = preg_replace('/^標題：/', '', $myMindResponse['articles'][$key]['title']);

                $dom = new \DOMDocument();
                @$dom->loadHTML($article['html']); // 加上 '@' 忽略 HTML parsing 的錯誤訊息
                $imgTags = $dom->getElementsByTagName('img');

                if ($imgTags->length > 0) {
                    $src = $imgTags[0]->getAttribute('src');
                    $myMindResponse['articles'][$key]['image'] = $src;
                }
            }

            // 判斷是否為營養師
            $is_rd = Session::get('is_rd', false);
            if ($is_rd) {
                // 若為營養師，則獲取相關數據
                $records = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getRecords/')->json();
                $myMindResponse = array_merge($myMindResponse, ['record' => $records]);
            } else {
                $subcategorys = array_slice($subcategorys, 10, 5);
            }

            // 合併其他必要數據
            $myMindResponse = array_merge($myMindResponse, [
                'sidebar' => 'user',
                'title' => 'my_mind',
                'web_name' => 'None',
                'nickname' => Session::get('nickname', ''),
                'user_mail' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => $token,
                'postStorageds' => $postStoraged,
                'subcategorys' => $subcategorys,
            ]);

            return response()->view('user/my_mind', $myMindResponse)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

        } else {
            return redirect()->route('user_login');
        }
    }
}
