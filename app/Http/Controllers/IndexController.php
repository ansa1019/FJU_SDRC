<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    //
    public function indexView(Request $request)
    {
        $token = Session::get('jwt_token', '');
        $calendarMsg = "";
        $personalCalendar = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/personalCalendar/')->json();
        if (empty($subPersonalCalendarJson)) {
            $calendarMsg = "尚未有任何快到的日子";
        } else {
            if ($subPersonalCalendarJson[0]['type'] == 'menstruation') {
                $calendarMsg = "月經快來囉";
            } elseif ($subPersonalCalendarJson[0]['type'] == 'miscarriage period') {
                $calendarMsg = "小產期快到囉";
            } elseif ($subPersonalCalendarJson[0]['type'] == 'pregnancy') {
                $calendarMsg = "產期快到囉";
            } elseif ($subPersonalCalendarJson[0]['type'] == 'menopause') {
                $calendarMsg = "更年期到囉";
            } elseif ($subPersonalCalendarJson[0]['type'] == 'postpartum_period') {
                $calendarMsg = "產後期快到囉";
            }
        }

        $response = [
            'articles' => Http::asForm()->get(env('API_IP') . 'api/content/textEditorPost/?ordering=-created_at')->json(),
            'articles_official' => Http::asForm()->get(env('API_IP') . 'api/content/PostGetOfficial/?ordering=-created_at')->json(),
            'get_tag' => Http::asForm()->get(env('API_IP') . 'api/content/hashTag/')->json(),
            'products' => Http::asForm()->get(env('API_IP') . 'api/product/product/?ordering=-exchaged')->json(),
            'recommendUser' => Http::asForm()->get(env('API_IP') . 'api/userprofile/recommendUser/')->json()
        ];
        // dd($response);
        if ($response['articles'] != []) {
            $response['articles'] = array_slice($response['articles'], 0, 4);
        } else {
            $response['articles'] = [];
        }
        if ($response['articles_official'] != []) {
            $response['articles_official'] = array_slice($response['articles_official'], 0, 4);
        } else {
            $response['articles_official'] = [];
        }
        if ($response['products'] != []) {
            $response['products'] = array_slice($response['products'], 0, 4);
        } else {
            $response['products'] = [];
        }
        if ($response['recommendUser'] != []) {
            $response['recommendUser'] = array_slice($response['recommendUser'], 0, 4);
        } else {
            $response['recommendUser'] = [];
        }

        foreach (['articles', 'articles_official'] as $text) foreach ($response[$text] as $key => $article) {
                $response[$text][$key]['comment_count'] = count($article['comments']);

                $dom = new \DOMDocument();
                $dom->loadHTML($article['html']);
                $imgTags = $dom->getElementsByTagName('img');
                // echo $imgTags[0]->getAttribute('src');
                if ($imgTags[0] !== null) {
                    $src = $imgTags[0]->getAttribute('src');
                    $response[$text][$key]['image'] = $src;
                }
            }

        foreach ($response['recommendUser'] as $key => $user) {
            $response['recommendUser'][$key]['subscribeCount'] = count($user['subscribe']);
        }

        foreach ($response['get_tag']['hashtags'] as $key => $tag) {
            $response['get_tag']['hashtags'][$key] = str_replace('#', '', $tag);
        }

        $response = array_merge($response, [
            'sidebar' => 'None',
            'title' => 'None',
            'nickname' => Session::get('nickname', ''),
            'user_mail' => Session::get('user_email', ''),
            'jwt_token' => Session::get('jwt_token', ''),
            'user_image' => Session::get('user_image', ''),
            'calendarMsg' => $calendarMsg,
            'personalCalendar' => $personalCalendar,
        ]);
        // dd($response);
        return view('index', $response);
    }
}
