<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Sendchkmail;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    public function UserEditpassword(Request $request)
    {


        // 获取用户提供的旧密码和新密码
        $formData = [
            'oldPassword' => $request->input('old_password'),
            'password' => $request->input('new_password')
        ];

        $newpassword = $request->input('new_password');
        $token = Session::get('jwt_token');
        // 請求用戶的資料
        $UserProfileresponse = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/auth/user_config/');

        $UserPorfile = $UserProfileresponse->json();
        $userid = intval($UserPorfile[0]['id']);
        //更改用戶密碼
        $editUserProfileresponse = ApiHelper::editAuthenticatedRequest($token, env('API_IP') . 'api/auth/user_config/', $formData, $userid);
        // dd($editUserProfileresponse->json());

        if ($editUserProfileresponse->status() == 200) {
            // 密码成功更改
            return redirect()->route('user_login')->with('successful', '密碼更改成功，請重新登入');
        } else {
            // 密码更改失败
            dd('error');
            return redirect('user_info')->with('error', '密碼更改失敗');
        }
    }


    public function UserInfoEdit(Request $request)
    {
        $formData = [
            'token' => $request->input('jwt_token'),
            'user_id' => $request->input('profile_id'),
            "user_drug" => $request->input("user_drug"),
            "user_order" => $request->input("user_order"),
            "user_allergy" => $request->input("user_allergy"),
            //用戶ID
            'bodyProfile_id' => $request->input('bodyProfile_id'),
            //用戶身體資料ID
            'user_email' => $request->input('user_email'),
            //信箱
            'user_name' => $request->input('user_name'),
            //用戶真實姓名
            'user_nickname' => $request->input('user_nickname'),
            // 用戶暱稱
            'gender' => $request->input('gender'),
            // 性別
            'birthday' => $request->input('datepicker'),
            //生日
            'height' => $request->input('user_height'),
            //身高
            'weight' => $request->input("user_weight"),
            //體重
            'married_state' => $request->input("married_state"),
            //婚姻狀況
            'pregnant_state' => $request->input("pregnant_state"),
            //懷孕狀況
            'birth_plan' => $request->input("birth_plan"),
            //生育計畫
            'disease' => $request->input("disease_history"),
            //病史
            'other_disease' => $request->input("disease_other"),
            //其他病史
            'allergy_state' => $request->input("allergy_other"),
            //過敏
            'order' => $request->input("order_other"),
            //醫囑
            'drug' => $request->input("drug_other"),
            //藥物
            'phone' => $request->input("user_phone"),
            //電話
            'address' => $request->input("user_address"),
            //住址
        ];

        $formrUserProfile = [
            "user_drug" => $formData['user_drug'],
            "user_order" => $formData['user_order'],
            "user_allergy" => $formData['user_allergy'],
            "user_name" => $formData['user_name'],
            "email" => $formData['user_email'],
            'nickname' => $formData['user_nickname'],
            'gender' => $formData['gender'],
            'birthday' => $formData['birthday'],
            'phone' => $formData['phone'],
            'address' => $formData['address'],
        ];
        $diseaseHistoryArray = $request->input("disease_history");
        $medical_history = '';

        if (!empty($diseaseHistoryArray)) {
            $medical_history = implode(',', $diseaseHistoryArray);
        }

        // dd($formrUserProfile);

        $formUserbodyProfile = [
            'height' => $formData['height'],
            'weight' => $formData['weight'],
            'family_planning' => $formData['birth_plan'],
            'expecting' => $formData['pregnant_state'],
            'medical_history' => $medical_history,
            'other_medical_history' => $formData['other_disease'],
            'medication' => $formData['drug'],
            'doctor_advice' => $formData['order'],
            'allergy' => $formData['allergy_state'],
            'marriage' => $formData['married_state'] == 'married' ? 1 : 0,
        ];
        $token = Session::get('jwt_token');
        $userid = (string) $formData['user_id'];
        $bodyid = (string) $formData['bodyProfile_id'];
        // dd($formrUserProfile);

        $Profileresponse = ApiHelper::editAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/profile/', $formrUserProfile, $userid);
        if ($Profileresponse->successful()) {
            $BodyProfileresponse = ApiHelper::editAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/bodyProfile/', $formUserbodyProfile, $bodyid);
            if ($BodyProfileresponse->successful()) {
                $successMessage = '修改個人資料成功!';
                Session::put('nickname', $formrUserProfile['nickname']);
                $this->UserInfoView();
                return back()->with('successful', $successMessage)->with('sidebar', 'None');
            } else {
                // 修改個人身體資料失敗
                $errorMessage = '修改個人資料失敗，請稍後再試';
                return back()->withErrors(['error' => $errorMessage])->with('sidebar', 'None');
            }
        } else {
            // 修改個人資料失敗
            $errorMessage = '修改個人資料失敗，請稍後再試';
            return back()->withErrors(['error' => $errorMessage])->with('sidebar', 'None');
        }
    }

    public function UserInfoView()
    {
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $responseProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/profile/')->json()[0];
            $responseBodyProfile = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/bodyProfile/')->json()[0];
            $responseProfile['profile_id'] = $responseProfile['id'];
            $responseBodyProfile['bodyProfile_id'] = $responseBodyProfile['id'];
            $responseBodyProfile['medical_history'] = explode(',', $responseBodyProfile['medical_history']);
            unset($responseProfile['id']);
            unset($responseBodyProfile['id']);
            $responseProfile = $responseProfile + $responseBodyProfile;

            $diseases = [
                '高血壓' => 0,
                '糖尿病' => 0,
                '腎臟病' => 0,
                '癌症' => 0,
                '外食道逆流' => 0,
                '便秘' => 0,
                '甲狀腺亢進/低下' => 0,
                '子宮肌瘤' => 0,
                '多囊性卵巢' => 0,
                '子宮肌腺症' => 0,
                '巧克力囊腫' => 0,
                '子宮外孕' => 0,
                '骨盆腔發炎' => 0,
                '流產' => 0,
                '子宮內膜異位' => 0
            ];
            foreach ($diseases as $disease => $val) {
                if (in_array($disease, $responseProfile['medical_history'])) {
                    $diseases[$disease] = 1;
                }
            }

            $responseProfile = array_merge($responseProfile, [
                'sidebar' => 'user',
                'title' => 'user',
                'web_name' => 'user_info',
                'user_email' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'diseases' => $diseases,
                'jwt_token' => Session::get('jwt_token', ''),
            ]);
            // dd($responseProfile);
            return view('user/user_info', $responseProfile);
        } else {
            $routeController = new RouteController();
            return $routeController->user_login();
        }
    }

    public function articleBookmarkView()
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/')->json(),
                'articles_official' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/')->json()
            ];
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();

            if ($token != '' && $postStorageds == []) {
                $formdata = [
                    'storage_name' => '不分類收藏',
                ];

                $addpostStoraged = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])->post(env('API_IP') . 'api/userdetail/postStoraged/', $formdata);
            }

            // dd($response);
            $num = 0;
            foreach ($response['articles'] as $article) {
                $response['articles'][$num]['comment_count'] = count($article['comments']);
                $num += 1;
            }

            $num = 0;
            foreach ($response['articles_official'] as $article) {
                $response['articles_official'][$num]['comment_count'] = count($article['comments']);
                $num += 1;
            }

            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'article_saved_list',
                'jwt_token' => $token,
                'postStorageds' => $postStorageds
            ]);
            // dd($response);
            return view('user/article_saved_list', $response);
        } else {
            return redirect()->route('user_login');
        }
    }

    public function articleBookmarkcollectView()
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/')->json(),
                'articles_official' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/')->json()
            ];
            // dd($response);
            $num = 0;
            foreach ($response['articles'] as $article) {
                $response['articles'][$num]['comment_count'] = count($article['comments']);
                $num += 1;
            }

            $num = 0;
            foreach ($response['articles_official'] as $article) {
                $response['articles_official'][$num]['comment_count'] = count($article['comments']);
                $num += 1;
            }

            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'article_saved_collect',
                'jwt_token' => $token,
            ]);
            // dd($response);
            return view('user/article_saved_collect', $response);
        } else {
            return redirect()->route('user_login');
        }
    }

    public function folderArticlesView()
    {
        // 檢查是否有驗證過的 JWT token
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            // 從 API 獲取文章數據
            $articles = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/')->json();
            $articles_official = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/')->json();

            // 處理文章數據，例如計算評論數量等
            foreach ($articles as &$article) {
                $article['comment_count'] = count($article['comments']);
            }
            foreach ($articles_official as &$article) {
                $article['comment_count'] = count($article['comments']);
            }

            // 將數據傳遞到視圖中
            $data = [
                'articles' => $articles,
                'articles_official' => $articles_official,
                'sidebar' => 'user',
                'title' => 'article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'article_saved_collect',
                'jwt_token' => $token,
            ];

            // 返回視圖，將數據傳遞到 folder_articles.php 頁面
            return view('folder_articles', $data);
        } else {
            // 如果沒有 JWT token，則重定向到登錄頁面
            return redirect()->route('user_login');
        }
    }


    public function articleAuthorSavedView()
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribe/')->json();
            // dd($response);
            $articles = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/')->json();
            $articles_official = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/')->json();
            $articles = array_merge($articles, $articles_official);

            $response['article_num'] = [];
            foreach ($response['subscribe'] as $sub) {
                $response['article_num'][$sub[0]['nickname']] = 0;
                $is_click = 0;
                foreach ($articles as $article) {
                    if ($sub[0]['nickname'] == $article['identity']) {
                        $response['article_num'][$sub[0]['nickname']] += 1;
                        if ($article['click']['in_user'][0] == true) {
                            $is_click += 1;
                        }
                    }
                }
                $response['article_num'][$sub[0]['nickname'] . '_new_article'] = $response['article_num'][$sub[0]['nickname']] - $is_click;
            }

            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'author_saved',
                'jwt_token' => $token,
            ]);
            // dd($response);
            return view('user/author_saved', $response);
        } else {
            return redirect()->route('user_login');
        }
    }

    public function articleTopicSavedView()
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subscribeHashtag/')->json();
            // dd($response);
            $articles = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/textEditorPost/')->json();
            $articles_official = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/content/PostGetOfficial/')->json();
            $articles = array_merge($articles, $articles_official);
            // dd($articles);
            $response['article_num'] = [];
            foreach ($response['subHashtag'] as $sub) {
                $response['article_num'][$sub] = 0;
                $is_click = 0;
                foreach ($articles as $article) {
                    $article['hashtag'] = array_filter(explode(',', $article['hashtag']), 'strlen');
                    if (in_array($sub, $article['hashtag'])) {
                        $response['article_num'][$sub] += 1;
                        if ($article['click']['in_user'][0] == true) {
                            $is_click += 1;
                        }
                    }
                }
                $response['article_num'][$sub . '_new_article'] = $response['article_num'][$sub] - $is_click;
            }

            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'topic_saved',
                'jwt_token' => $token,
            ]);
            // dd($response);
            return view('user/topic_saved', $response);
        } else {
            return redirect()->route('user_login');
        }
    }

    public function postStoragedArticleList($name = null)
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $postStorageds = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postStoraged/')->json();

            foreach ($postStorageds as $postStoraged) {
                if ($postStoraged['storage_name'] === $name) {
                    $id = $postStoraged['id'];
                    $response = ['articles' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userdetail/postlist/' . $id . '/')->json()["post"]];
                }
            }
            // dd($response['articles']);

            foreach ($response['articles'] as $key => $article) {
                $response['articles'][$key]['comment_count'] = count($article['comments']);
                if ($article['is_official'] == false) {
                    $dom = new \DOMDocument();
                    $dom->loadHTML($article['html']);
                    $imgTags = $dom->getElementsByTagName('img');
                    // echo $imgTags[0]->getAttribute('src');
                    if ($imgTags[0] !== null) {
                        $src = $imgTags[0]->getAttribute('src');
                        $response['articles'][$key]['image'] = $src;
                    }
                } else {
                    $response['articles'][$key]['hashtag'] = str_replace(',', '', $response['articles'][$key]['hashtag']);
                }
            }

            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'author_article',
                'nickname' => Session::get('nickname', ''),
                'user_image' => Session::get('user_image', ''),
                'web_name' => 'postStoraged_article_list',
                'jwt_token' => $token,
                'storage_name' => $name,
                'postStorageds' => $postStorageds
            ]);
            // dd($response);
            return response()->view('user/article_saved_collect', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        } else {
            return redirect()->route('user_login');
        }
    }

    public function notifications_view()
    {
        //
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'notifications' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/notifications/notifications/')->json(),
            ];
            // dd($response);

            foreach ($response['notifications'] as $key => $notify) {
                $response['notifications'][$key]['created_at'] = Carbon::parse($notify['created_at'])->format('Y-m-d H:i:s');
            }

            $response = array_merge($response, [
                'nickname' => Session::get('nickname', ''),
                'user_mail' => Session::get('user_email', ''),
                'user_image' => Session::get('user_image', ''),
                'jwt_token' => $token,
                'update_time' => date("Y-m-d H:i:s"),
            ]);
            // dd($response);
            return response()->view('user/notifications', $response)->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        } else {
            return redirect()->route('user_login');
        }
    }
    public function sendchkmail(Request $request)
    {
        try {
            $mail = new Sendchkmail(
                $request->user_name, // 用戶暱稱
                $request->verification_code
            );

            // 發送郵件
            Mail::to($request->user_name)->send($mail);
            $successMessage = '已發送驗證碼到您的信箱';
            // 重定向到登录后的页面或返回成功响应
            return $successMessage;
        } catch (\Exception $e) {
            // dd($e->getMessage()); // 用於調試
            $warningMessage = '發送郵件失敗: ' . $e->getMessage();
            return $warningMessage;
        }
    }
}
