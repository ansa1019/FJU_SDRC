<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use function PHPSTORM_META\type;

class ManageController extends Controller
{
    public function article_report_view($category = null, $sort = '-created_at')
    {
        //
        $token = Session::get('jwt_token', '');
        $is_rd = Session::get('is_rd', '');
        if ($is_rd) {
            if ($category == 'treatment') {
                $response = [
                    'articles' => array_merge(
                        ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/?ordering=' . $sort)->json(),
                        ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getTmpPost/?ordering=' . $sort)->json()
                    )
                ];
            } else {
                $response = [
                    'articles' => array_merge(
                        ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/?ordering=' . $sort)->json(),
                        ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/TempOfficialPostGet/?ordering=' . $sort)->json()
                    )
                ];
            }

            $records = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/getRecords/')->json();
            foreach ($response['articles'] as $key => $article) {
                if (($category == 'treatment' && $article['is_official'] == false) || ($category == 'knowledge' && $article['is_official'] == true)) {
                    $response['articles'][$key]['comment_count'] = count($article['comments']);
                    $response['articles'][$key]['created_at'] = Carbon::parse($article['created_at'])->format('Y-m-d H:i:s');
                    $response['articles'][$key]['time'] = $records[$response['articles'][$key]['id']]["time"];

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
            // dd($response);

            $response = array_merge($response, [
                'nickname' => Session::get('nickname', ''),
                'user_mail' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'category' => $category,
                'jwt_token' => $token,
                "record" => $records,
                'update_time' => date("Y-m-d H:i:s"),
            ]);
            // dd($response);
            return response()->view('user/article_report', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function blacklist_manage_view()
    {
        //
        $token = Session::get('jwt_token', '');
        $is_rd = Session::get('is_rd', '');
        if ($is_rd) {
            $response = [
                'status' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/blacklist/status/')->json(),
                'blacklists' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/blacklist/blacklist/')->json(),
            ];
            if ($response['blacklists'] != null) {
                foreach ($response['blacklists'] as $key => $bl) {
                    $response['blacklists'][$key]['created_at'] = Carbon::parse($bl['created_at'])->format('Y-m-d H:i:s');
                }
            } else {
                $response['blacklists'] = [];
            }
            // dd($response);

            $response = array_merge($response, [
                'nickname' => Session::get('nickname', ''),
                'user_mail' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => $token,
                'update_time' => date("Y-m-d H:i:s"),
            ]);
            // dd($response);
            return response()->view('user/blacklist_manage', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }
}
