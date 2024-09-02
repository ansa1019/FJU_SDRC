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
        $token = Session::get('jwt_token', '');
        if ($token != '') {
            $response = [
                'personalCalendar' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/personalCalendar/')->json(),
                'subPersonalCalendar' => ApiHelper::getAuthenticatedRequest($token, env('API_IP') . 'api/userprofile/subPersonalCalendar/')->json()
            ];
            $response = array_merge($response, [
                'sidebar' => 'user',
                'title' => 'calendar',
                'web_name' => 'None',
                'nickname' => Session::get('nickname', ''),
                'jwt_token' => Session::get('jwt_token', ''),
                'user_image' => Session::get('user_image', ''),
            ]);
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
            // post生理期personalCalendar
            $personalCalendarDataForm = [
                'type' => 'menstruation',
                'cycle' => intval($request['menstrualCycle']),
                'date' => Carbon::parse($request['lastMenstrual'])->toDateString(),
                'cycle_days' => intval($request['menstruationLast']),
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post生理期subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];

            $fieldsToCheck = ['menstrualPeriod', 'has_mc', 'no_mc', 'mc_less', 'mc_normal', 'mc_more', 'pain_less', 'pain_normal', 'pain_more', 'menstrualPeriodHeadache', 'backache', 'hecticFever', 'breastTenderness', 'OvulationPain', 'menstrualPeriodConstipate', 'diarrhea', 'increasedSecretions', 'spottingHemorrhage', 'menstrualPeriodOther', 'noRoommate', 'roommateContraception', 'roommateNoContraception'];

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
            // post懷孕期personalCalendar
            $personalCalendarDataForm = [
                'type' => 'pregnancy',
                'cycle' => intval($request['weeksPregnancy']),
                'date' => Carbon::parse($request['dueDate'])->toDateString(),
                'cycle_days' => intval($request['menstruationLast']),
            ];

            $personalCalendar = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post(env('API_IP') . 'api/userprofile/personalCalendar/', $personalCalendarDataForm);

            // post懷孕期subPersonalCalendar
            $requestData = $request->all();
            $dataToInclude = [];

            $fieldsToCheck = ['pregnancyPeriod', 'has_blood', 'no_blood', 'blood_less', 'blood_normal', 'blood_more', 'blood_pink', 'blood_red', 'blood_darkred', 'vaginalBleeding', 'backPain', 'pregnancyChestPain', 'lowerAbdominalPain', 'pregnancyNausea', 'pregnancyVomit', 'pregnancyDizziness', 'pregnancyConstipate', 'pregnancyFrequentUrination', 'upsetStomach', 'pregnancyIndigestion', 'pregnancyOther'];

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
