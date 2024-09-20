<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RouteController extends Controller
{
    public function index()
    {
        return view('index', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function knowledge_library()
    {
        return view('knowledge/knowledge_library', ['sidebar' => 'knowledge', 'title' => 'knowledge', 'web_name' => 'knowledge_library', 'nickname' => Session::get('nickname', '')]);
    }

    public function knowledge_article()
    {
        return view('knowledge/knowledge_article', ['sidebar' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function user_login()
    {
        return view('login/user_login', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::has('userNickName') ? Session::get('userNickName') : '', 'user_image' => Session::get('user_image', ''),]);
    }

    public function user_signout()
    {
        session()->forget('jwt_token');
        session()->forget('nickname');
        session()->forget('user_image');
        session()->forget('blacklist');
        session()->forget('banlist');
        session()->forget('notifications');
        session()->forget('is_rd');
        return redirect('/user_login')->with(['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', ''), 'successful' =>'登出成功']);
    }
    
    public function user_register()
    {
        return view('user/user_register', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', ''), 'user_image' => Session::get('user_image', ''),]);
    }
    
    public function mail_register()
    {
        return view('mail/mail_register', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function my_mind()
    {
        return view('user/my_mind', ['sidebar' => 'user', 'title' => 'my_mind', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function calendar()
    {
        return view('user/calendar', ['sidebar' => 'user', 'title' => 'calendar', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function point_task()
    {
        return view('user/point_task', ['sidebar' => 'user', 'title' => 'point', 'web_name' => 'point_task', 'nickname' => Session::get('nickname', '')]);
    }

    public function point_exchange()
    {
        return view('user/point_exchange', ['sidebar' => 'user', 'title' => 'point', 'web_name' => 'point_exchange', 'nickname' => Session::get('nickname', '')]);
    }

    public function point_gift1()
    {
        return view('user/point_gift1', ['sidebar' => 'user', 'title' => 'point', 'web_name' => 'point_gift1', 'nickname' => Session::get('nickname', '')]);
    }

    public function point_get_record()
    {
        return view('user/point_get_record', ['sidebar' => 'user', 'title' => 'point', 'web_name' => 'point_get_record', 'nickname' => Session::get('nickname', '')]);
    }

    public function point_use_record()
    {
        return view('user/point_use_record', ['sidebar' => 'user', 'title' => 'point', 'web_name' => 'point_use_record', 'nickname' => Session::get('nickname', '')]);
    }

    public function article_saved_list()
    {
        return view('user/article_saved_list', ['sidebar' => 'user', 'title' => 'article', 'web_name' => 'article_saved_list', 'nickname' => Session::get('nickname', '')]);
    }

    public function author_saved()
    {
        return view('user/author_saved', ['sidebar' => 'user', 'title' => 'article', 'web_name' => 'author_saved', 'nickname' => Session::get('nickname', '')]);
    }

    public function topic_saved()
    {
        return view('user/topic_saved', ['sidebar' => 'user', 'title' => 'article', 'web_name' => 'topic_saved', 'nickname' => Session::get('nickname', '')]);
    }

    public function privacy()
    {
        return view('about/privacy', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }
    public function tos()
    {
        return view('about/tos', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function notifications()
    {
        return view('notifications', ['sidebar' => 'None', 'title' => 'None', 'web_name' => 'None', 'nickname' => Session::get('nickname', '')]);
    }

    public function test()
    {
        return view('test', ['sidebar' => 'None', 'title' => 'artice', 'web_name' => 'test', 'nickname' => Session::get('nickname', '')]);
    }
}
