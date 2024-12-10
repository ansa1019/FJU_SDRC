<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            $cycle = $latestMenstruation ? $latestMenstruation['calendar']['cycle'] : null;
            $lastMenstrual = $latestMenstruation ? $latestMenstruation['start_date'] : null;
            // 準備回應的資料
            $response = [
                'personalCalendar' => $personalCalendar,
                'subPersonalCalendar' => $subPersonalCalendar,
                'personalmenstrual' => $personalmenstrual,
                'cycle' => $cycle,
                'lastMenstrual' => $lastMenstrual,
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

            // 從 API 獲取個人月經資料
            $personal_menstrual = ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/menstrual/')->json();

            if (empty($personal_menstrual)) {
                // 初次記錄，更新 next_date
                $nextMenstrualDate = $recordDate->copy()->addDays($cycle); // 預測下一次月經日期

                $personalCalendarDataForm = [
                    'type' => 'menstruation',
                    'cycle' => $cycle,
                    'date' => $lastMenstrual->toDateString(),
                    'cycle_days' => $cycleDays,
                    'menstrual' => true,
                    'record_date' => $recordDate->toDateString(),
                    'next_date' => $nextMenstrualDate->toDateString(),
                ];

            } else {
                // 後續記錄
                $startDate = Carbon::parse($personal_menstrual[0]['start_date']);
                $endDate = Carbon::parse($personal_menstrual[0]['end_date']);

                // 判斷紀錄日期是否在生理期範圍內或填寫「沒有月經」，保持現有 next_date，不做任何更新
                if ($recordDate->between($startDate, $endDate) || $request['no_mc'] == '沒有') {
                    $personalCalendarDataForm = [
                        'type' => 'menstruation',
                        'cycle' => $cycle,
                        'date' => $lastMenstrual->toDateString(),
                        'cycle_days' => $cycleDays,
                        'menstrual' => false,
                    ];
                } else {
                    // 填寫其他值（例如有月經），更新 next_date
                    $nextMenstrualDate = $recordDate->copy()->addDays($cycle);
                    $personalCalendarDataForm = [
                        'type' => 'menstruation',
                        'cycle' => $cycle,
                        'date' => $lastMenstrual->toDateString(),
                        'cycle_days' => $cycleDays,
                        'menstrual' => true,
                        'record_date' => $recordDate->toDateString(),
                        'next_date' => $nextMenstrualDate->toDateString(),
                    ];
                }
            }


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

            $subPersonalCalendarDataForm = [
                'calendar_id' => $personalCalendar->json()['id'],
                'dict' => $dataToInclude,
            ];

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

        } elseif ($request['health_type'] == 'pregnancy') {
            // 從請求中獲取填寫的懷孕期日期和預產期
            $pregnancyPeriodString = $request->input('pregnancyPeriod', $lastPregnancyData['pregnancyPeriod'] ?? null);
            $dueDateString = $request->input('dueDate', $lastPregnancyData['dueDate'] ?? null);

            // 確保填寫的日期存在且是有效的日期格式
            $pregnancyPeriod = $pregnancyPeriodString ? Carbon::parse($pregnancyPeriodString) : null;
            $dueDate = $dueDateString ? Carbon::parse($dueDateString) : null;

            // 確保日期存在並且預產期比懷孕期晚
            if ($pregnancyPeriod && $dueDate && $dueDate->greaterThan($pregnancyPeriod)) {
                // 計算懷孕的總天數
                $totalPregnancyDays = $dueDate->diffInDays($pregnancyPeriod);

                // 計算已經過去的天數
                $daysPassed = $pregnancyPeriod->diffInDays(Carbon::now());

                // 計算剩餘的天數
                $remainingDays = $totalPregnancyDays - $daysPassed;
                $remainingWeeks = floor(max(0, $remainingDays) / 7);
                $remainingDays = max(0, $remainingDays % 7);
            } else {
                // 如果日期無效或預產期早於懷孕期，將倒數設為0
                $remainingWeeks = 0;
                $remainingDays = 0;
            }

            // 儲存倒數的週數和天數到 Session
            session([
                'remaining_weeks' => $remainingWeeks,
                'remaining_days' => $remainingDays,
                'due_date' => optional($dueDate)->toDateString() ?: '', // 如果 dueDate 是 null，則返回空字串
                'health_type' => 'pregnancy',
                'pregnancy_data' => [
                    'pregnancyPeriod' => optional($pregnancyPeriod)->toDateString() ?: '',
                    'dueDate' => optional($dueDate)->toDateString() ?: '',
                ],
            ]);

            // post 懷孕期的 personalCalendar
            $personalCalendarDataForm = [
                'type' => 'pregnancy',
                'cycle' => $request->has('weeksPregnancy') ? intval($request['weeksPregnancy']) : null,
                'date' => optional($dueDate)->toDateString() ?: '', // 如果 dueDate 是 null，則返回空字串
                'cycle_days' => intval($request['menstruationLast']),
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post懷孕期subPersonalCalendar
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

            // 發送 subPersonalCalendar 的資料
            $subPersonalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/subPersonalCalendar/', $subPersonalCalendarDataForm);
            // 成功後返回日曆頁面
            return redirect()
                ->route('Calendar')
                ->with(['success' => '懷孕期月曆新增成功']);
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
