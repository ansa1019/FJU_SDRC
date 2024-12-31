<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class CalendarController extends Controller
{
    public function CalendarIndex()
    {

        // 檢查是否有 JWT token
        $token = Session::get('jwt_token', '');
        if ($token != '') {

            // 嘗試從 API 抓取個人日曆和子日曆資料
            $personalCalendar = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/personalCalendar/')->json();
            $subPersonalCalendar = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subPersonalCalendar/')->json();
            $personalmenstrual = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/menstrual/')->json();

            // 找出最新的生理期紀錄
            $latestMenstruation = $personalmenstrual ? $personalmenstrual[0] : null;

            // 找到最新的生理期紀錄
            $cycle = $latestMenstruation ? $latestMenstruation['calendar']['cycle'] : ($personalCalendar ? end($personalCalendar)['cycle'] : null);
            $cycle_days = $latestMenstruation ? $latestMenstruation['calendar']['cycle_days'] : ($personalCalendar ? end($personalCalendar)['cycle'] : null);
            $lastMenstrual = $latestMenstruation ? $latestMenstruation['start_date'] : null;
            $next_menstrual_date = $latestMenstruation ? $latestMenstruation['next_date'] : null;

            // 懷孕期資料處理
            $remainingWeeks = 0;
            $remainingDays = 0;
            $dueDate = null;

            if (!empty($personalCalendar) && !empty($subPersonalCalendar)) {
                $latestPersonal = end($personalCalendar); 
                $latestSubPersonal = end($subPersonalCalendar)['dict']; 

                // 提取懷孕期日期
                $dueDate = isset($latestPersonal['date']) ? Carbon::parse($latestPersonal['date']) : null;
                $pregnancyStartDate = isset($latestSubPersonal['pregnancyPeriod']) ? Carbon::parse($latestSubPersonal['pregnancyPeriod']) : null;

                if ($dueDate && $pregnancyStartDate) {
                    // 計算剩餘天數
                    $totalDays = $dueDate->diffInDays($pregnancyStartDate);
                    $remainingDays = $totalDays;

                    // 計算剩餘週數和天數
                    $remainingWeeks = intval(floor($remainingDays / 7));
                    $remainingDays = $remainingDays % 7;
                }
            }
            // dd($latestPersonal['date'] );
            // 準備回應的資料
            $response = [
                'personalCalendar' => $personalCalendar,
                'subPersonalCalendar' => $subPersonalCalendar,
                'personalmenstrual' => $personalmenstrual,
                'cycle' => $cycle,
                'cycle_days' => $cycle_days,
                'lastMenstrual' => $lastMenstrual,
                'next_menstrual_date' => $next_menstrual_date,
                'dueDate' => $dueDate ? $dueDate->toDateString() : null,
                'remainingWeeks' => $remainingWeeks,
                'remainingDays' => $remainingDays,
                'sidebar' => 'user',
                'title' => 'calendar',
                'web_name' => 'None',
                'nickname' => Session::get('nickname', ''),
                'jwt_token' => Session::get('jwt_token', ''),
                'user_image' => Session::get('user_image', ''),
            ];

            return view('user/calendar', $response);
        } else {
            return redirect()->route('user_login');
        }
    }

    public function CalendarPost(Request $request)
    {
        // dd($request->all());
        $token = Session::get('jwt_token', '');
        $error = "";

        if ($request['health_type'] == 'menstruation') {
            $token = Session::get('jwt_token', '');
            session(['health_type' => 'menstruation']);

            // 解析日期與週期數據
            $lastMenstrual = Carbon::parse($request['lastMenstrual']);
            $recordDate = Carbon::parse($request['menstrualPeriod']);
            $cycle = intval($request['menstrualCycle']);
            $cycleDays = intval($request['menstruationLast']);

            $personalCalendarDataForm = [
                'type' => 'menstruation',
                'cycle' => $cycle,
                'date' => $lastMenstrual->toDateString(),
                'cycle_days' => $cycleDays
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // 儲存額外的資料到 subPersonalCalendar
            $dataToInclude = [];
            $fieldsToCheck = [
                'menstrualPeriod',
                'has_mc',
                'no_mc',
                'mc_less',
                'mc_normal',
                'mc_more',
                'pain_no',
                'pain_less',
                'pain_normal',
                'pain_more',
                'menstrualPeriodHeadache',
                'backache',
                'hecticFever',
                'breastTenderness',
                'OvulationPain',
                'menstrualPeriodConstipate',
                'diarrhea',
                'increasedSecretions',
                'spottingHemorrhage',
                'menstrualPeriodOther',
                'noRoommate',
                'roommateContraception',
                'roommateNoContraception'
            ];

            foreach ($fieldsToCheck as $field) {
                if (isset($request[$field]) && !empty($request[$field])) {
                    $dataToInclude[$field] = $request[$field];
                }
            }

            // 從 API 獲取個人月經資料
            $personal_menstrual = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/menstrual/')->json();

            if (empty($personal_menstrual)) {
                // 初次記錄，更新 next_date
                if ($request['no_mc'] == '沒有' || $recordDate->between($lastMenstrual, $lastMenstrual->copy()->addDays(10),false)) {
                    $nextMenstrualDate = $lastMenstrual->copy()->addDays($cycle);
                    $subPersonalCalendarDataForm = [
                        'calendar_id' => $personalCalendar->json()['id'],
                        'dict' => $dataToInclude,
                        'menstrual' => true,
                        'start_date' => $lastMenstrual->toDateString(),
                        'next_date' => $nextMenstrualDate->toDateString(),
                    ];
                } else {
                    $nextMenstrualDate = $recordDate->copy()->addDays($cycle);
                    $subPersonalCalendarDataForm = [
                        'calendar_id' => $personalCalendar->json()['id'],
                        'dict' => $dataToInclude,
                        'menstrual' => true,
                        'last_date' => $lastMenstrual->toDateString(),
                        'start_date' => $recordDate->toDateString(),
                        'next_date' => $nextMenstrualDate->toDateString(),
                    ];
                }
            } else {
                // 後續記錄
                $startDate = Carbon::parse($personal_menstrual[0]['start_date']);
                $endDate = Carbon::parse($personal_menstrual[0]['end_date']);

                // 判斷紀錄日期是否在生理期範圍內或填寫「沒有月經」，保持現有 next_date，不做任何更新
                if ($recordDate->between($startDate, $endDate) || $request['no_mc'] == '沒有') {
                    $nextMenstrualDate = $personal_menstrual[0]['next_date'];
                    $subPersonalCalendarDataForm = [
                        'calendar_id' => $personalCalendar->json()['id'],
                        'dict' => $dataToInclude,
                        'menstrual' => false,
                    ];
                } else {
                    // 填寫其他值（例如有月經），更新 next_date
                    $nextMenstrualDate = $recordDate->copy()->addDays($cycle);
                    $subPersonalCalendarDataForm = [
                        'calendar_id' => $personalCalendar->json()['id'],
                        'dict' => $dataToInclude,
                        'menstrual' => true,
                        'start_date' => $recordDate->toDateString(),
                        'next_date' => $nextMenstrualDate->toDateString(),
                    ];
                }
            }

            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);

            // 跳轉回日曆頁面，顯示成功訊息
            return redirect()
                ->route('Calendar')
                ->with(['success' => '生理期月曆新增成功']);
        } elseif ($request['health_type'] == 'miscarriage period') {
            // post小產期personalCalendar
            $personalCalendarDataForm = [
                'type' => 'miscarriage period',
                'cycle' => 0,
                'date' => Carbon::parse($request['miscarriageDay'])->toDateString(),
                'cycle_days' => 0,
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post小產期subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];

            $fieldsToCheck = ['miscarriagePeriod', 'miscarriagePeriodHas_loc', 'miscarriagePeriodNo_loc', 'miscarriagePeriodLoc_less', 'miscarriagePeriodLoc_normal', 'miscarriagePeriodLoc_more', 'miscarriagePeriodLoc_red', 'miscarriagePeriodLoc_darkred', 'miscarriagePeriodContractions', 'miscarriagePeriodBackache', 'largeBloodClots', 'fever', 'nausea', 'vomit', 'dizziness', 'chestPain', 'miscarriagePeriodOther'];

            foreach ($fieldsToCheck as $field) {
                if (isset($requestData[$field]) && !empty($requestData[$field])) {
                    $dataToInclude[$field] = $requestData[$field];
                }
            }

            $subPersonalCalendarDataForm = [
                'calendar_id' => $personalCalendar->json()['id'],
                'dict' => $dataToInclude,
            ];

            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);
            return redirect()
                ->route('Calendar')
                ->with(['success' => '小產期月曆新增成功']);

        }elseif ($request['health_type'] == 'pregnancy') {
            // 從請求中獲取懷孕期開始日期和預產期
            $pregnancyPeriodString = $request->input('pregnancyPeriod');
            $dueDateString = $request->input('dueDate');        
            // 解析日期
            $pregnancyPeriod = $pregnancyPeriodString ? Carbon::parse($pregnancyPeriodString) : null;
            $dueDate = $dueDateString ? Carbon::parse($dueDateString) : null;
            
            // 計算剩餘天數
            if ($pregnancyPeriod && $dueDate && $dueDate->greaterThan($pregnancyPeriod)) {
                $remainingDays = $dueDate->diffInDays($pregnancyPeriod);        
                $remainingWeeks = intval(floor($remainingDays / 7));
                $remainingDays = $remainingDays % 7;
            } else {
                $remainingWeeks = 0;
                $remainingDays = 0;
            }        
            
            // 新增至 personalCalendar
            $personalCalendarDataForm = [
                'type' => 'pregnancy',
                'cycle' => $request->has('weeksPregnancy') ? intval($request['weeksPregnancy']) : null,
                'date' => optional($dueDate)->toDateString() ?: '',
            ];
        
            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);
            
            // 處理 subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];
            $fieldsToCheck = [
                'pregnancyPeriod',
                'has_blood',
                'no_blood',
                'blood_less',
                'blood_normal',
                'blood_more',
                'blood_pink',
                'blood_red',
                'blood_darkred',
                'vaginalBleeding',
                'backPain',
                'pregnancyChestPain',
                'lowerAbdominalPain',
                'pregnancyNausea',
                'pregnancyVomit',
                'pregnancyDizziness',
                'pregnancyConstipate',
                'pregnancyFrequentUrination',
                'upsetStomach',
                'pregnancyIndigestion',
                'pregnancyOther'
            ];            
            foreach ($fieldsToCheck as $field) {
                if (isset($requestData[$field]) && !empty($requestData[$field])) {
                    $dataToInclude[$field] = $requestData[$field];
                }
            }
        
            $subPersonalCalendarDataForm = [
                'calendar_id' => $personalCalendar->json()['id'],
                'dict' => $dataToInclude,
            ];
        
            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);
        
            // 更新倒數時間並回傳
            return redirect()
                ->route('Calendar')
                ->with([
                    'success' => '懷孕期月曆新增成功',
                    'remainingWeeks' => $remainingWeeks,
                    'remainingDays' => $remainingDays,
                ]);
        
        
        } elseif ($request['health_type'] == 'postpartum_period') {
            // post// post產後期personalCalendar
            $personalCalendarDataForm = [
                'type' => 'postpartum_period',
                'cycle' => 0,
                'date' => Carbon::parse($request['productionPeriod'])->toDateString(),
                'cycle_days' => 0,
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post產後期subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];

            $fieldsToCheck = ['postpartumPeriod', 'postpartumPeriodHas_loc1', 'postpartumPeriodNo_loc1', 'postpartumPeriodLoc_less', 'postpartumPeriodLoc_normal', 'postpartumPeriodLoc_more', 'postpartumPeriodLoc_red', 'postpartumPeriodLoc_darkred', 'postpartumPeriodContractions', 'postpartumPeriodBackache', 'postpartumPeriodLargeBloodClots', 'lossOfAppetite', 'postpartumPeriodIndigestion', 'postpartumPeriodConstipate', 'itching', 'postpartumPeriodChestPain', 'postpartumPeriodOther'];

            foreach ($fieldsToCheck as $field) {
                if (isset($requestData[$field]) && !empty($requestData[$field])) {
                    $dataToInclude[$field] = $requestData[$field];
                }
            }

            $subPersonalCalendarDataForm = [
                'calendar_id' => $personalCalendar->json()['id'],
                'dict' => $dataToInclude,
            ];

            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);
            return redirect()
                ->route('Calendar')
                ->with(['success' => '產後期月曆新增成功']);
        } elseif ($request['health_type'] == 'menopause') {
            // post更年期personalCalendar
            $personalCalendarDataForm = [
                'type' => 'menopause',
                'cycle' => 0,
                'date' => Carbon::parse($request['menopausePeriod'])->toDateString(),
                'cycle_days' => 0,
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post更年期subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];

            $fieldsToCheck = ['menopausePeriod', 'hotFlashes', 'nightSweats', 'coldHandsAndFeet', 'difficultyFallingAsleep', 'vaginalDryness', 'vaginalItching', 'menopauseFrequentUrination', 'menopauseHeadache', 'menopauseOther'];

            foreach ($fieldsToCheck as $field) {
                if (isset($requestData[$field]) && !empty($requestData[$field])) {
                    $dataToInclude[$field] = $requestData[$field];
                }
            }

            $subPersonalCalendarDataForm = [
                'calendar_id' => $personalCalendar->json()['id'],
                'dict' => $dataToInclude,
            ];

            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);
            return redirect()
                ->route('Calendar')
                ->with(['success' => '更年期月曆新增成功']);
        }
    }
}
