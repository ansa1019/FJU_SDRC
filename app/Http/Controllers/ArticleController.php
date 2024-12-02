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
        $token = Session::get('jwt_token', '');
        $subcategorys = Http::asForm()->get(env('API_IP') . 'api/content/subcategory/')->json();
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

        if ($token != '' && empty($postStorageds)) {
            $formdata = [
                'storage_name' => '不分類收藏',
            ];

            $addpostStoraged = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();
        }

        if (is_array($postStorageds)) {
            // 更新收藏夾封面圖片的邏輯
            foreach ($postStorageds as &$postStoraged) {
                // 預設圖片設置為隨機的預設圖片
                $defaultImages = [
                    asset('static/img/img_1.png'),
                    asset('static/img/img_2.png'),
                    asset('static/img/img_3.png'),
                    asset('static/img/img_4.png')
                ];
                $postStoraged['latest_article_image'] = $defaultImages[array_rand($defaultImages)];

                if (!empty($articles) && is_array($articles)) {
                    // 嘗試找到第一個包含自定義圖片的文章
                    foreach ($articles as $article) {
                        if (!empty($article['image']) && strpos($article['image'], 'default_image') === false) {
                            $postStoraged['latest_article_image'] = $article['image'];
                            break;
                        } elseif (!empty($article['index_image']) && strpos($article['index_image'], 'default_image') === false) {
                            $postStoraged['latest_article_image'] = $article['index_image'];
                            break;
                        }
                    }
                }
            }
        }

        if (!empty($response['temporary_article'])) {
            $response['temporary_article'][0]['hashtag'] = str_replace(',', '', $response['temporary_article'][0]['hashtag']);
        }

        $response['subTopic'] = 0;
        if (!empty($subTopic)) {
            foreach ($subTopic[0]['topic'] as $sub) {
                if ($sub == $category) {
                    $response['subTopic'] = 1;
                    break;
                }
            }
        }

        if (!empty($response['articles'])) {
            foreach ($response['articles'] as $key => $article) {
                if ($article['is_official'] == false) {
                    $response['articles'][$key]['comment_count'] = count($article['comments']);
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
            'subcategorys' => array_slice($subcategorys, 10, 5),
            'sort' => $sort,
            'postStorageds' => $postStorageds
        ]);

        return response()->view('treatment/treatment_qa', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function TreatmentArticleGet($id)
    {
        if (!$id) {
            abort(404, '文章 ID 未提供');
        }
        $token = Session::get('jwt_token', '');
        $subcategorys = Http::asForm()->get(env('API_IP') . 'api/content/subcategory/')->json();
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
        $article_title = $response['title'] ?? '預設標題';
        $description = $response['description'] ?? '文章描述未提供';
        $index_image = $response['index_image'] ?? asset('static/img/default_cover_image.png'); // 取出封面圖片
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

        $response['article_title'] = $response['title'] ?? '未提供標題';
        $response['cover_image'] = $response['cover_image'] ?? asset('static/img/default_cover_image.png');
        $response['description'] = $response['description'] ?? '文章描述未提供';
        $response['comment_count'] = count($response['comments'] ?? []);

        if (isset($response['click']['in_user'][0]) && $response['click']['in_user'][0] == false) {
            $response['is_click'] = 0;
        } else {
            $response['is_click'] = 1;
        }

        if (!empty($response['hashtag'])) {
            $response['hashtag'] = array_filter(explode(',', $response['hashtag']), 'strlen');
            foreach ($response['hashtag'] as $key => $tag) {
                $response['hashtag'][$key] = str_replace('#', '', $tag);
            }
        } else {
            $response['hashtag'] = [];
        }

        $response['subscribe'] = 0;
        if (!empty($subscribe)) {
            foreach ($subscribe as $items) {
                foreach ($items as $sub) {
                    if (isset($sub[0]['nickname']) && $sub[0]['nickname'] == $response['identity']) {
                        $response['subscribe'] = 1;
                        break;
                    }
                }
            }
        }

        $latest_articles = [];
        $extend_articles = [];
        $popular_articles = Http::asForm()->get(env('API_IP') . 'api/content/orderByClick/')->json();
        $all_articles = Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/?ordering=-created_at')->json();
        if (!empty($all_articles)) {
            $latest_articles = array_slice($all_articles, 0, 2);
            if (!empty($popular_articles)) {
                $popular_articles = array_slice($popular_articles['data'], 0, 2);
            }
            foreach ($all_articles as $key => $articles) {
                if (isset($response['category'][0]['name']) && $response['category'][0]['name'] == $articles['category'][0]['name']) {
                    $extend_articles[$key] = $articles;
                }
            }
            $extend_articles = array_slice($extend_articles, 0, 2);
        }

        $date = Carbon::parse($response['created_at'] ?? now());
        $response['date'] = $date->format('Y-m-d');

        $response = array_merge($response, [
            'latest_articles' => $latest_articles,
            'extend_articles' => $extend_articles,
            'popular_articles' => $popular_articles,
            'sidebar' => ['article', 'TreatmentArticleGet'],
            'title' => 'None',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'is_rd' => Session::get('is_rd', ''),
            'jwt_token' => $token,
            'subcategorys' => array_slice($subcategorys, 10, 5),
            'postStorageds' => $postStorageds,
            'record' => $records[$id],
            'update_time' => date("Y-m-d H:i:s"),
            'article_title' => $article_title,
            'description' => $description,
            'index_image' => $index_image,
        ]);

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
