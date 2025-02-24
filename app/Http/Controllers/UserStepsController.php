<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStepsController extends Controller
{
    //
    public function getCurrentStep(Request $request)
    {
        try {
            $user = Auth::user();
            $nowDayStep = $user->userSteps()->whereDate('created_at', now())->first();
            return response()->success([
                'step_count' => $nowDayStep->step_count ?? 0,
                "coin_count" => $user->coin_count ?? 0,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }

    public function userStepInc(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'step' => 'required|integer',
            ]);
            $step = $request->step;
            $nowDayStep = $user->userSteps()->whereDate('created_at', now())->first();
            if ($nowDayStep) {
                if ($nowDayStep->step_count + $step > 10000) {
                    return response()->error("Günlük 10000 adım limitin üstüne çıkamazsınız.", "", 400);
                } else {
                    $user->coin_count += $step;
                    $user->save();
                    $nowDayStep->step_count = $nowDayStep->step_count + $step;
                    $nowDayStep->save();
                }
            } else {
                if ($step > 10000) {
                    return response()->error("Günlük 10000 adım limitin üstüne çıkamazsınız.", "", 400);
                }
                $user->coin_count += $step;
                $user->save();
                $user->userSteps()->create([
                    'step_count' => $step,
                ]);
            }
            return response()->success($nowDayStep);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }

    public function allUserSteps(Request $request)
    {
        try {
            $user = Auth::user();
            $allUserSteps = $user->userSteps()->orderBy('created_at', 'desc')->get();
            return response()->success($allUserSteps);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }
    public function lastSevenDayList(Request $request)
    {
        try {

            $user = Auth::user();
            $sevenDayList = [];

            for ($i = 0; $i < 7; $i++) {
                $date = now()->subDays($i)->startOfDay();
                $step = $user->userSteps()->whereDate('created_at', '=', $date)->get()->first();
                $dayOfWeek = ucfirst(Carbon::parse($date)->locale('tr_TR')->shortDayName);
                $dayInfo = [
                    // 'date' => $date->toDateTimeString(),
                    'dayOfWeek' => $dayOfWeek,
                    "count" => ($step->step_count) ?? 0,
                ];
                array_push($sevenDayList, $dayInfo);
            }
            return response()->success($sevenDayList);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }

}
