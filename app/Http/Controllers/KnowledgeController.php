<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class KnowledgeController extends Controller
{
    public function knowledgeView($category = null, $subcategory = null, $sort = '-created_at')
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/?ordering=' . $sort)->json(),
                'temporary_article' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/TempOfficialPostGet/')->json()
            ];
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            $subTopic = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subTopic/')->json();
        } else {
            $response = ['articles' => Http::asForm()->get(env('API_IP') . 'api/content/PostGetOfficial/?ordering=' . $sort)->json()];
            $response['temporary_article'] = [];
            $subTopic = [];
            $postStorageds = [];
        }
        // dd($response);

        if ($token != '' && $postStorageds == null) {
            $formdata = [
                'storage_name' => '不分類收藏',
            ];

            $addpostStoraged = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
        }

        if ($response['temporary_article'] != []) {
            $response['temporary_article'][0]['hashtag'] = str_replace(',', '', $response['temporary_article'][0]['hashtag']);
        }

        $response['subTopic'] = 0;
        if ($subTopic != []) {
            foreach ($subTopic[0]['topic'] as $sub) {
                if ($sub == $subcategory) {
                    $response['subTopic'] = 1;
                    break;
                }
            }
        }

        if ($response['articles'] != []) {
            foreach ($response['articles'] as $key => $article) {
                if ($article['is_official'] == true) {
                    $response['articles'][$key]['comment_count'] = count($article['comments']);
                } else {
                    unset($response['articles'][$key]);
                }
            }
        }

        $response = array_merge($response, [
            'sidebar' => 'knowledge',
            'title' => 'knowledge',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'is_rd' => Session::get('is_rd', ''),
            'category' => $category,
            'subcategory' => $subcategory,
            'jwt_token' => $token,
            'sort' => $sort,
            'postStorageds' => $postStorageds
        ]);
        // dd($response);
        return response()->view('knowledge/knowledge_library', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function knowledgeArticleGet($id = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/' . $id . '/')->json();
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            $subscribe = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribe/')->json();
        } else {
            $response = Http::asForm()->get(env('API_IP') . 'api/content/PostGetOfficial/' . $id . '/')->json();
            $subscribe = [];
            $postStorageds = [];
        }
        // dd($response);

        if ($token != '' && $postStorageds == null) {
            $formdata = [
                'storage_name' => '不分類收藏',
            ];

            $addpostStoraged = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
        }

        $response['article_title'] = $response['title'];
        $response['comment_count'] = count($response['comments']);
        if ($response['click']['in_user'][0] == false) {
            $response['is_click'] = false;
        } else {
            $response['is_click'] = true;
        }

        if ($response['hashtag']) {
            $response['hashtag'] = array_filter(explode(',', $response['hashtag']), 'strlen');
            foreach ($response['hashtag'] as $key => $tag) {
                $response['hashtag'][$key] = str_replace('#', '', $tag);
            }
        } else {
            $response['hashtag'] = [];
        }

        $response['subscribe'] = 0;
        if ($subscribe != []) {
            foreach ($subscribe as $items) foreach ($items as $sub) {
                    if ($sub[0]['nickname'] == $response['identity']) {
                        $response['subscribe'] = 1;
                        break;
                    }
                }
        }

        $latest_articles = [];
        $extend_articles = [];
        $popular_articles = Http::asForm()->get(env('API_IP') . 'api/content/orderByClickOfficial/')->json()['data'];
        $all_articles = Http::asForm()->get(env('API_IP') . 'api/content/PostGetOfficial/?ordering=-created_at')->json();
        if ($all_articles != null) {
            $latest_articles = array_slice($all_articles, 0, 2);
            if ($popular_articles != null) {
                $popular_articles = array_slice($popular_articles, 0, 2);
            }
            foreach ($all_articles as $key => $articles) {
                if ($response['category'][0]['name'] == $articles['category'][0]['name']) {
                    $extend_articles[$key] = $articles;
                }
            }
            $extend_articles = array_slice($extend_articles, 0, 2);
        }

        $date = Carbon::parse($response['created_at']);
        if ($date->month >= 10) {
            $response['date'] = $date->year . '-' . $date->month . '-' . $date->day;
        } else {
            $response['date'] = $date->year . '-0' . $date->month . '-' . $date->day;
        }

        if (Session::get('is_rd')) {
            $records = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getRecords/')->json();
            $response = array_merge($response, ['record' => $records[$id]]);
        }

        $response = array_merge($response, [
            'latest_articles' => $latest_articles,
            'extend_articles' => $extend_articles,
            'popular_articles' => $popular_articles,
            'all_articles' => $all_articles,
            'sidebar' => ['article', 'knowledge_article'],
            'title' => 'None',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'is_rd' => Session::get('is_rd', ''),
            'jwt_token' => $token,
            'postStorageds' => $postStorageds,
            'update_time' => date("Y-m-d H:i:s"),
        ]);
        // dd($response);
        return view('knowledge/knowledge_article', $response);
    }

    public function KnowledgeArticleUpdate($id = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/' . $id . '/')->json();
        } else {
            $response = Http::asForm()->get(env('API_IP') . 'api/content/PostGetOfficial/' . $id . '/')->json();
        }

        return response()->json($response);
    }
}
