<?php

namespace App\Http\Controllers\Point;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RouteController;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
    public function userpointView()
    {
        $token = Session::get('jwt_token', '');

        // --以下手動新增點數
        // $formData = [
        //     'point' => "100000"
        // ];
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $token,
        // ])->post(env('API_IP').'api/point/userPoint/', $formData);

        // dd($response);
        // --以上手動新增點數

        $responseTaskRecord = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/task/taskRecord/')->json();

        $personalProgress = end($responseTaskRecord);
        array_pop($responseTaskRecord);
        // dd($responseTaskRecord, $personalProgress);


        $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();

        if (empty($responsePointProfile)) {
            $formData = [
                'point' => "1000"
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post(env('API_IP') . 'api/point/userPoint/', $formData);
        }

        foreach ($responseTaskRecord as $key => $value) {
            if ($responseTaskRecord[$key]['progress'] > $responseTaskRecord[$key]['task_progress']) {
                $responseTaskRecord[$key]['progress'] = $responseTaskRecord[$key]['task_progress'];
            }
            ;
        }

        if ($token != '') {
            $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();
            unset($responsePointProfile['id']);
            return view('user/point_task', $responsePointProfile)->with([
                'title' => 'point',
                'sidebar' => 'user',
                'point' => $responsePointProfile[0]['point'],
                'web_name' => 'point_task',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => Session::get('jwt_token', ''),
                'responseTaskRecord' => $responseTaskRecord,
                'personalProgress' => $personalProgress
            ]);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function userpointGiftView()
    {
        $token = Session::get('jwt_token', '');

        if ($token != '') {
            $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();
            unset($responsePointProfile['id']);
            return view('user/point_gift1', $responsePointProfile)->with([
                'title' => 'point',
                'sidebar' => 'user',
                'point' => $responsePointProfile[0]['point'],
                'web_name' => 'point_gift1',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => Session::get('jwt_token'),
                'token' => $token
            ]);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function userpointGift(Request $request)
    {
        $token = Session::get('jwt_token', '');

        $formData = [
            'point' => $request->input('gift_points'),
            'receiver' => $request->input('gift_account')
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('API_IP') . 'api/point/gift/', $formData);

        if ($response->successful()) {
            return redirect('/point_gift1')->with(['successMsg' => '操作成功', 'gift' => $response->json()["id"]]);
        } else {
            return redirect('/point_gift1')->with('errorMsg', '操作失敗');
        }
    }

    public function userpointGetRecordView()
    {
        $token = Session::get('jwt_token', '');

        if ($token != '') {
            $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();
            $responsePointRecord = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/gift/')->json();
            $responseTaskPointRecord = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/systemPoint/')->json();
            unset($responsePointProfile['id']);
            $responseAllRecord = array_merge($responsePointRecord, $responseTaskPointRecord);
            // $responseAllRecord = collect($responseAllRecord)->sortByDesc('created_at');
            $responseAllRecord = collect($responseAllRecord)->map(function ($record) {
                $record['created_at'] = date('Y-m-d H:i:s', strtotime($record['created_at']));
                return $record;
            })->sortByDesc('created_at');
            // dd($responsePointRecord, $responsePointProfile, $responseTaskPointRecord);
            return view('user/point_get_record', $responsePointProfile)->with([
                'title' => 'point',
                'sidebar' => 'user',
                'point' => $responsePointProfile[0]['point'],
                'web_name' => 'point_get_record',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => Session::get('jwt_token', ''),
                'user' => $responsePointProfile[0]['user'],
                'responseAllRecord' => $responseAllRecord
            ]);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function userpointUseRecordView()
    {
        $token = Session::get('jwt_token', '');

        if ($token != '') {
            $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();
            $responsePointRecord = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/gift/')->json();
            $responseexchangeProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/exchange/')->json();
            $responseAllRecord = array_merge($responsePointRecord, $responseexchangeProfile);
            // $responseAllRecord = collect($responseAllRecord)->sortByDesc('created_at');
            $responseAllRecord = collect($responseAllRecord)->map(function ($record) {
                $record['created_at'] = date('Y-m-d H:i:s', strtotime($record['created_at']));
                return $record;
            })->sortByDesc('created_at');
            // dd($responseexchangeProfile);
            return view('user/point_use_record', $responsePointProfile)->with([
                'title' => 'point',
                'sidebar' => 'user',
                'point' => $responsePointProfile[0]['point'],
                'web_name' => 'point_use_record',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => Session::get('jwt_token', ''),
                'user' => $responsePointProfile[0]['user'],
                'responseAllRecord' => $responseAllRecord
            ]);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function userpointExchangeView()
    {
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $responsePointProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/point/userPoint/')->json();
            $responseProduct = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/product/product/')->json();

            return view('user/point_exchange', $responsePointProfile)->with([
                'title' => 'point',
                'responseProduct' => $responseProduct,
                'sidebar' => 'user',
                'id' => $responsePointProfile[0]['id'],
                'point' => $responsePointProfile[0]['point'],
                'web_name' => 'point_exchange',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => Session::get('jwt_token', '')
            ]);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }
    public function exchangeProductform(Request $request)
    {
        // dd($request->all);
    }
}