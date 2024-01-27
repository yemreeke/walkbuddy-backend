<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStepsController extends Controller
{
    //

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
                if ($nowDayStep->step_count + $step > 2000) {
                    return response()->error("Günlük 2000 adım limitin üstüne çıkamazsınız.", "", 400);
                } else {
                    $user->coin_count += $step;
                    $user->save();
                    $nowDayStep->step_count = $nowDayStep->step_count + $step;
                    $nowDayStep->save();
                }
            } else {
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
            $allUserSteps = $user->userSteps()->get();
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
            $lastSevenDayList = $user->userSteps()->whereDate('created_at', '>=', now()->subDays(7))->get();
            return response()->success($lastSevenDayList);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }

}
