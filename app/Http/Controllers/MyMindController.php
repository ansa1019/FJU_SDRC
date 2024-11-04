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
            $myMindResponse = ['articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/userGetSelfPost/')->json()];
            $postStoraged = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            if ($token != '' && $postStoraged == []) {
                $formdata = [
                    'storage_name' => '不分類收藏',
                ];

                $addpostStoraged = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            }
            // dd($myMindResponse);
            foreach ($myMindResponse['articles'] as $key => $article) {
                $myMindResponse['articles'][$key]['comment_count'] = count($article['comments']);

                $myMindResponse['articles'][$key]['title'] = preg_replace('/^標題：/', '', $myMindResponse['articles'][$key]['title']);
                $dom = new \DOMDocument();
                $dom->loadHTML($article['html']);
                $imgTags = $dom->getElementsByTagName('img');
                // echo $imgTags[0]->getAttribute('src');
                if ($imgTags[0] !== null) {
                    $src = $imgTags[0]->getAttribute('src');
                    $myMindResponse['articles'][$key]['image'] = $src;
                }
            }

            // return view('user/my_mind', ['sidebar' => 'user', 'title' => 'my_mind', 'web_name' => 'None', 'nickname' => Session::get('nickname', ''), 'articles' => $myMindResponse['articles'], 'user_mail' => Session::get('user_email', ''), 'user_image' => Session::get('user_image', ''),]);

            $myMindResponse = array_merge($myMindResponse, [
                'sidebar' => 'user',
                'title' => 'my_mind',
                'web_name' => 'None',
                'nickname' => Session::get('nickname', ''),
                'user_mail' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => $token,
                'postStorageds' => $postStoraged,
                'subcategorys' => array_slice($subcategorys, 10, 5),
            ]);
            return response()->view('user/my_mind', $myMindResponse)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

        } else {
            return redirect()->route('user_login');
        }
    }
}
