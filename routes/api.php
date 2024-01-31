<?php


use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IbanTransfersController;
use App\Http\Controllers\UserStepsController;
use Illuminate\Support\Facades\Route;


### KULLANICI APİLERİ ###

Route::post('user/login', [UserController::class, 'login']); // Kullanıcı Girişi
Route::post('user/register', [UserController::class, 'register']); // Kullanıcı Kaydı
Route::get('products/list', [ProductsController::class, 'list']); // Ürünleri Listeler



Route::middleware(["jwt"])->group(function () {

    ### KULLANICI APİLERİ ###
    Route::get('user/self', [UserController::class, 'self']); // Kullanıcı bilgilerini getirir
    Route::put('user/update', [UserController::class, 'update']); // Kullanıcı bilgilerini günceller
    Route::delete('user/delete', [UserController::class, 'destroy']); // Kullanıcı siler
    Route::put("user/changePassword", [UserController::class, "changePassword"]); // Kullanıcı şifresini günceller

    Route::post("steps/incUserSteps", [UserStepsController::class, "userStepInc"]); // Adım Sayısını Arttırır
    Route::get("steps/lastSevenDayList", [UserStepsController::class, "lastSevenDayList"]); // Son 7 Günün Adım Sayılarını Getirir
    Route::get("steps/allUserSteps", [UserStepsController::class, "allUserSteps"]); // Bütün Adımları Getirir
    Route::get("steps/getCurrentStep", [UserStepsController::class, "getCurrentStep"]); // Anlık Adım Sayısını Getirir


    Route::post("iban/transfer", [IbanTransfersController::class, "transfer"]); // Iban Transferi Yapar
    Route::get("iban/listTransfers", [IbanTransfersController::class, "listTransfers"]); // Iban Transferlerini Listeler

    Route::post('orders/create', [OrdersController::class, 'create']); // Sipariş Oluşturur
    Route::get('orders/list', [OrdersController::class, 'userOrderList']); // Kullanıcının Siparişlerini Listeler
});

