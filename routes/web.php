<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Mail\OrderShipped;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\IndexController::class, 'indexView'])->name('index');
Route::get('/test', [App\Http\Controllers\RouteController::class, 'test'])->name('test');

//知識圖書館
Route::get('/knowledge_library/{category?}/{subcategory?}/{sort?}', [App\Http\Controllers\KnowledgeController::class, 'knowledgeView'])->name('knowledge_library');
Route::get('/knowledge_article/{id}', [App\Http\Controllers\KnowledgeController::class, 'knowledgeArticleGet'])->name('knowledge_article');
Route::get('/KnowledgeArticleUpdate/{id?}', [App\Http\Controllers\KnowledgeController::class, 'KnowledgeArticleUpdate'])->name('KnowledgeArticleUpdate');

//療心室
Route::get('/treatment_qa/{article?}/{sort?}', [App\Http\Controllers\ArticleController::class, 'treatment_view'])->name('treatment_qa');
Route::get('/TreatmentArticleGet/{id}', [App\Http\Controllers\ArticleController::class, 'TreatmentArticleGet'])->name('TreatmentArticleGet');
Route::post('/TreatmentQaCreate', [App\Http\Controllers\ArticleController::class, 'TreatmentArticleCreate'])->name('TreatmentQaCreate');
Route::get('/TreatmentArticleUpdate/{id?}', [App\Http\Controllers\ArticleController::class, 'TreatmentArticleUpdate'])->name('TreatmentArticleUpdate');

//文章搜尋
Route::get('/searchArticle/{searchText?}/{sort?}/{is_hashtag?}', [App\Http\Controllers\Search\SearchController::class, 'searchView'])->name('searchArticle');
Route::get('/searchArticleUpdate/{id?}', [App\Http\Controllers\Search\SearchController::class, 'searchArticleUpdate'])->name('searchArticleUpdate');

//登入、註冊、登出
Route::get('/user_login', [App\Http\Controllers\RouteController::class, 'user_login'])->name('user_login');
Route::get('/user/signout', [App\Http\Controllers\RouteController::class, 'user_signout'])->name('user.signout');
Route::get('/user_register', [App\Http\Controllers\RouteController::class, 'user_register'])->name('user_register');

//mail
Route::get('/mail_register', [App\Http\Controllers\RouteController::class, 'mail_register'])->name('mail_register');

//會員中心
Route::get('/user_info', [App\Http\Controllers\Auth\UserInfoController::class, 'UserInfoView'])->name('user_info');

//日曆
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'CalendarIndex'])->name('CalendarIndex');
Route::post('/calendar', [App\Http\Controllers\CalendarController::class, 'CalendarPost'])->name('Calendar');

//使用者點數
Route::get('/point_task', [App\Http\Controllers\Point\PointController::class, 'userpointView'])->name('point_task');
Route::get('/point_exchange', [App\Http\Controllers\Point\PointController::class, 'userpointExchangeView'])->name('point_exchange');
// Route::get('/point_gift1', [App\Http\Controllers\RouteController::class, 'point_gift1'])->name('point_gift1');
Route::get('/point_gift1', [App\Http\Controllers\Point\PointController::class, 'userpointGiftView'])->name('point_gift1');
Route::post('/point_gift', [App\Http\Controllers\Point\PointController::class, 'userpointGift'])->name('point_gift');
// Route::get('/point_get_record', [App\Http\Controllers\RouteController::class, 'point_get_record'])->name('point_get_record');
Route::get('/point_get_record', [App\Http\Controllers\Point\PointController::class, 'userpointGetRecordView'])->name('point_get_record');
// Route::get('/point_use_record', [App\Http\Controllers\RouteController::class, 'point_use_record'])->name('point_use_record');
Route::get('/point_use_record', [App\Http\Controllers\Point\PointController::class, 'userpointUseRecordView'])->name('point_use_record');

//我的心事
Route::get('/my_mind', [App\Http\Controllers\MyMindController::class, 'myMindView'])->name('my_mind');

//文章收藏
Route::get('/article_saved_list', [App\Http\Controllers\Auth\UserInfoController::class, 'articleBookmarkView'])->name('article_saved_list');
Route::get('/article_saved_collect/{name?}', [App\Http\Controllers\Auth\UserInfoController::class, 'postStoragedArticleList'])->name('article_saved_collect');

//作者文章
Route::get('/author_saved', [App\Http\Controllers\Auth\UserInfoController::class, 'articleAuthorSavedView'])->name('author_saved');
Route::get('/author_article_list/{author?}/{sort?}', [App\Http\Controllers\ArticleController::class, 'authorarticleview'])->name('author_article_list');

//話題追蹤
Route::get('/topic_saved', [App\Http\Controllers\Auth\UserInfoController::class, 'articleTopicSavedView'])->name('topic_saved');

//文章洞察
Route::get('/article_report/{category?}', [App\Http\Controllers\ManageController::class, 'article_report_view'])->name('article_report');
//檢舉管理
Route::get('/blacklist_manage', [App\Http\Controllers\ManageController::class, 'blacklist_manage_view'])->name('blacklist_manage');

//通知列表
Route::get('/notifications', [App\Http\Controllers\Auth\UserInfoController::class, 'notifications_view'])->name('notifications');


//隱私權政策、服務條款
Route::get('/tos', action: [App\Http\Controllers\RouteController::class, 'tos'])->name('tos');
Route::get('/privacy', action: [App\Http\Controllers\RouteController::class, 'privacy'])->name('privacy');


//登入表單
Route::post('/authenticate', [App\Http\Controllers\Auth\JWTsAuthController::class, 'authenticate'])->name('authenticate');
Route::post('/JumpUserRegister', [App\Http\Controllers\Auth\UserRegisterController::class, 'JumpUserRegister'])->name('JumpUserRegister');
Route::post('/UserRegister', [App\Http\Controllers\Auth\UserRegisterController::class, 'UserRegister'])->name('UserRegister');

//檢查註冊時暱稱是否重複
Route::post('/checknickname', [App\Http\Controllers\Auth\UserRegisterController::class, 'CheckNicknameRegister'])->name('checknickname');

//個人資料修改表單
Route::patch('/UserInfoEdit', [App\Http\Controllers\Auth\UserInfoController::class, 'UserInfoEdit'])->name('UserInfoEdit');
// Route::delete('/UserInfoEdit', [App\Http\Controllers\Auth\UserInfoController::class, 'UserInfoEdit'])->name('UserInfoEdit');

//更改密碼
// Route::post( '/UserEditpassword', [App\Http\Controllers\Auth\UserInfoController::class, 'UserEditpassword'])->name('UserEditpassword');
// Route::patch( '/UserEditpassword', [App\Http\Controllers\Auth\UserInfoController::class, 'UserEditpassword'])->name('UserEditpassword');
// 用於舊密碼驗證的 POST 路由
Route::post('/validate-old-password', [PasswordController::class, 'validateOldPassword'])->name('validateOldPassword');
Route::patch('/update-password', [PasswordController::class, 'updatePassword'])->name('updatePassword');
//使用者點數表單
// Route::post('/exchangeProductform', [App\Http\Controllers\Point\PointController::class, 'exchangeProductform'])->name('exchangeProductform');
//mail表單
// Route::get('/mail', function () {
//     Mail::to("test@gmail.com")->send(new OrderShipped());
// });

Route::post('/chkmail', [App\Http\Controllers\Auth\UserInfoController::class, 'chkmail'])->name('chkmail');
Route::post('/setUserimage', [App\Http\Controllers\Auth\JWTsAuthController::class, 'setUserimage'])->name('setUserimage');
Route::post('/setBanlist', [App\Http\Controllers\Auth\JWTsAuthController::class, 'setBanlist'])->name('setBanlist');
Route::post('/setBlacklist', [App\Http\Controllers\Auth\JWTsAuthController::class, 'setBlacklist'])->name('setBlacklist');
Route::post('/setNotifications', [App\Http\Controllers\Auth\JWTsAuthController::class, 'setNotifications'])->name('setNotifications');
Route::get('/get-image/{filename}', [App\Http\Controllers\ImageController::class, 'getImage']);