<?php
namespace App\Http\Controllers\Search;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function searchView($searchText = null, $sort = '-click', $is_hashtag = false)
    {
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/queryPost/?ordering=' . $sort . '&search=' . urlencode($searchText))->json()
            ];
            // dd($searchText);
            $subTopic = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribeHashtag/')->json();
            $get_tag = Http::asForm()->get(env('API_IP') . 'api/content/hashTag/')->json();
            $is_hashtag = in_array('#'.$searchText, $get_tag['hashtags']);
            $response['subTopic'] = in_array('#'.$searchText, $subTopic['subHashtag']) ? 1 : 0;
        } else {
            $response = [
                'articles' => Http::asForm()->get(env('API_IP') . 'api/content/queryPost/?ordering=' . $sort . '&search=' . urlencode($searchText))->json()
            ];
            $subTopic = [];
        }

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
            'sidebar' => 'none',
            'title' => 'none',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'user_image' => Session::get('user_image', ''),
            'jwt_token' => $token,
            'searchText' => $searchText,
            'sort' => $sort,
            'is_hashtag' => $is_hashtag
        ]);
        // dd($response);
        return response()->view('search/search_library', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function searchArticleUpdate($id = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/queryPost/' . $id . '/')->json();
        } else {
            $response = Http::asForm()->get(env('API_IP') . 'api/content/queryPost/' . $id . '/')->json();
        }

        return response()->json($response);
    }
}