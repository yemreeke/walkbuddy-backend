<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // İlk migrate yaparken string max karakterden dolayı
        // patlıyor o yüzden eklendi
        Schema::defaultStringLength(191);

        Response::macro('success', function ($data = null, $message = 'İşlem Başarılı', $status = 200) {
            return response()->json([
                'status' => $status,
                'data' => $data,
                'message' => $message,
            ], $status);
        });

        Response::macro('error', function ($message = 'Hata Oluştu', $messageDesc = "", $status = 400, $fingerPrint = "") {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'messageDesc' => $messageDesc,
            ], $status);
        });
    }
}