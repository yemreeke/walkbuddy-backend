<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IbanTransfersController extends Controller
{
    //

    public function transfer(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'coin' => 'required|integer',
            ]);

            $iban_no = $user->iban_no;
            $coin = $request->coin;
            $tl_price = $coin / 100;
            if ($iban_no == null || $iban_no == "") {
                return response()->error("Lütfen önce iban numaranızı giriniz.", "", 400);
            }
            if ($user->coin_count < $coin) {
                return response()->error("Yeterli coininiz bulunmamaktadır.", "", 400);
            } else {
                $user->coin_count -= $coin;

                $user->ibanTransfers()->create([
                    'iban_no' => $iban_no,
                    'tl_price' => $tl_price,
                ]);
                $user->save();
                return response()->success(null);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }


    public function listTransfers(Request $request)
    {
        try {
            $user = Auth::user();
            $allTransfers = $user->ibanTransfers()->get();
            return response()->success($allTransfers);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }
}
