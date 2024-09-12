<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use function PHPSTORM_META\type;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function TreatmentArticleCreate(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function treatment_view($category = null, $sort = '-created_at')
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/?ordering=' . $sort)->json(),
                'temporary_article' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getTmpPost/')->json()
            ];
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            $subTopic = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subTopic/')->json();
        } else {
            $response = ['articles' => Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/?ordering=' . $sort)->json()];
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
                if ($sub == $category) {
                    $response['subTopic'] = 1;
                    break;
                }
            }
        }

        if ($response['articles'] != []) {
            foreach ($response['articles'] as $key => $article) {
                if ($article['is_official'] == false) {
                    $response['articles'][$key]['comment_count'] = count($article['comments']);

                    $dom = new \DOMDocument();
                    $dom->loadHTML($article['html']);
                    $imgTags = $dom->getElementsByTagName('img');
                    // echo $imgTags[0]->getAttribute('src');
                    if ($imgTags[0] !== null) {
                        $src = $imgTags[0]->getAttribute('src');
                        $response['articles'][$key]['image'] = $src;
                    }
                } else {
                    unset($response['articles'][$key]);
                }
            }
        }

        $response = array_merge($response, [
            'sidebar' => 'treatment',
            'title' => 'treatment_qa',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'jwt_token' => $token,
            'category' => $category,
            'sort' => $sort,
            'postStorageds' => $postStorageds
        ]);
        // dd($response);
        return response()->view('treatment/treatment_qa', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function TreatmentArticleGet($id = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/' . $id . '/')->json();
            $records = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getRecords/')->json();
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            $subscribe = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribe/')->json();
        } else {
            $response = Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/' . $id . '/')->json();
            $records = Http::asForm()->get(env('API_IP') . 'api/content/getRecords/')->json();
            $subscribe = [];
            $postStorageds = [];
        }

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
            $response['is_click'] = 0;
        } else {
            $response['is_click'] = 1;
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
        $popular_articles = Http::asForm()->get(env('API_IP') . 'api/content/orderByClick/')->json();
        $all_articles = Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/?ordering=-created_at')->json();
        if ($all_articles != null) {
            $latest_articles = array_slice($all_articles, 0, 2);
            if ($popular_articles != null) {
                $popular_articles = array_slice($popular_articles['data'], 0, 2);
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

        $response = array_merge($response, [
            'latest_articles' => $latest_articles,
            'extend_articles' => $extend_articles,
            'popular_articles' => $popular_articles,
            // 'all_articles' => $all_articles,
            'sidebar' => ['article', 'TreatmentArticleGet'],
            'title' => 'None',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'is_rd' => Session::get('is_rd', ''),
            'jwt_token' => $token,
            'postStorageds' => $postStorageds,
            'record' => $records[$id],
            'update_time' => date("Y-m-d H:i:s"),
        ]);
        // dd($response['category']['0']['name']);
        return view('treatment/treatment_article', $response);
    }

    public function authorarticleview($author = null, $sort = '-created_at')
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/queryPost/?ordering=' . $sort)->json(),
            ];
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
            $subTopic = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subTopic/')->json();
            $subscribe = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribe/')->json();
        } else {
            $response = ['articles' => Http::asForm()->get(env('API_IP') . 'api/content/queryPost/?ordering=' . $sort)->json()];
            $subTopic = [];
            $postStorageds = [];
            $subscribe = [];
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

        $response['subscribe'] = 0;
        if ($subscribe != []) {
            foreach ($subscribe as $items) foreach ($items as $sub) {
                    if ($sub[0]['nickname'] == $author) {
                        $response['subscribe'] = 1;
                        break;
                    }
                }
        }
        // $response['subscribe'] = 0;
        // if ($subscribe != []) {
        //     foreach ($subscribe as $items) foreach ($items as $sub) {
        //             if ($sub[0]['nickname'] == $response['identity']) {
        //                 $response['subscribe'] = 1;
        //                 break;
        //             }
        //         }
        // }


        foreach ($response['articles'] as $key => $article) {
            $response['articles'][$key]['comment_count'] = count($article['comments']);

            $dom = new \DOMDocument();
            $dom->loadHTML($article['html']);
            $imgTags = $dom->getElementsByTagName('img');
            // echo $imgTags[0]->getAttribute('src');
            if ($imgTags[0] !== null) {
                $src = $imgTags[0]->getAttribute('src');
                $response['articles'][$key]['image'] = $src;
            }
        }

        $response = array_merge($response, [
            'title' => 'author_article',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'jwt_token' => $token,
            'sort' => $sort,
            'author' => $author,
            'postStorageds' => $postStorageds
        ]);
        // dd($response);
        return response()->view('user/author_article_list', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function TreatmentArticleUpdate($id = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/' . $id . '/')->json();
        } else {
            $response = Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/' . $id . '/')->json();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
