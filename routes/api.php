<?php

use App\Http\Controllers\AwsTranslateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CopyrightMessagesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\FirebasePushController;
use App\Http\Controllers\ForgotPasswordCodesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SuggestionMessagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSocialMediasController;
use Illuminate\Support\Facades\Route;


### KULLANICI APİLERİ ###

Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);



Route::middleware(["jwt"])->group(function () {

    ### KULLANICI APİLERİ ###

    Route::get('user/self', [UserController::class, 'self']); // Kullanıcı bilgilerini getirir
    Route::put('user/update', [UserController::class, 'update']); // Kullanıcı bilgilerini günceller
    Route::delete('user/delete', [UserController::class, 'destroy']); // Kullanıcı siler
    Route::put("user/changePassword", [UserController::class, "changePassword"]); // Kullanıcı şifresini günceller

});



Route::middleware(["jwt", "admin"])->group(function () {

    // Route::post("posts/viewSeedRandom", [PostsController::class, "viewSeedRandom"]); // El İşi Görüntülenme Sayısını Rastgele Arttırır

    // Route::get("messages/count", [SuggestionMessagesController::class, "count"]); // İstek Öneri mesajlarının sayısını getirir (Admin)


    // Route::get("copyright/list", [CopyrightMessagesController::class, "list"]); // Telif hakkı mesajlarını listeler (Admin //TODO : Silinecek
    // Route::put("copyright/read/{copyrightId}", [CopyrightMessagesController::class, "read"]); // Telif hakkı mesajı okunur olarak işaretler //TODO : Silinecek
    // Route::delete("copyright/delete/{copyrightId}", [CopyrightMessagesController::class, "delete"]); // Telif hakkı siler //TODO : Silinecek
    // Route::get("suggestion/list", [SuggestionMessagesController::class, "list"]); // İstek Öneri listeleme //TODO : Silinecek
    // Route::put("suggestion/read/{messageId}", [SuggestionMessagesController::class, "read"]); //  istek öneri okundu işaretleme //TODO : Silinecek
    // Route::delete("suggestion/delete/{messageId}", [SuggestionMessagesController::class, "delete"]); // İstek öneri silme  //TODO : Silinecek

    // Route::get("messages/copyright/list", [CopyrightMessagesController::class, "list"]); // Telif hakkı mesajlarını listeler (Admin
    // Route::put("messages/copyright/read/{copyrightId}", [CopyrightMessagesController::class, "read"]); // Telif hakkı mesajı okunur olarak işaretler
    // Route::delete("messages/copyright/delete/{copyrightId}", [CopyrightMessagesController::class, "delete"]); // Telif hakkı siler
    // Route::get("messages/suggestion/list", [SuggestionMessagesController::class, "list"]); // İstek Öneri listeleme
    // Route::put("messages/suggestion/read/{messageId}", [SuggestionMessagesController::class, "read"]); //  istek öneri okundu işaretleme
    // Route::delete("messages/suggestion/delete/{messageId}", [SuggestionMessagesController::class, "delete"]); // İstek öneri silme


    // Route::put("posts/updateStatusApproved/{postId}", [PostsController::class, "updateStatusApproved"]); // El İşi Durumunu Onaylar
    // Route::put("posts/updateStatusRejected/{postId}", [PostsController::class, "updateStatusRejected"]); // El İşi Durumunu Reddeder

    // Route::post('categories/', [CategoryController::class, 'store']); // Kategori Oluşturur  //TODO : Silinecek
    // Route::put('categories/{categoryId}', [CategoryController::class, 'update']); // Kategori Günceller  //TODO : Silinecek
    // Route::delete('categories/{categoryId}', [CategoryController::class, 'destroy']); // Kategori Sil  //TODO : Silinecek
    // Route::post('subCategories/{categoryId}/', [SubCategoryController::class, 'store']); // Alt Kategori Oluşturur  //TODO : Silinecek
    // Route::put('subCategories/{categoryId}/{subCategoryId}', [SubCategoryController::class, 'update']); // Alt Kategori Günceller  //TODO : Silinecek
    // Route::delete('subCategories/{categoryId}/{subCategoryId}', [SubCategoryController::class, 'destroy']); // Alt Kategori Sil  //TODO : Silinecek
    // Route::get("allSubCategories", [CategoryController::class, "allSubCategoriesList"]); // Tüm Kategorileri Getirir  //TODO : Silinecek


    // Route::post('categories/create', [CategoryController::class, 'store']); // Kategori Oluşturur
    // // Route::put('categories/update/{categoryId}', [CategoryController::class, 'update']); // Kategori Günceller
    // // Route::delete('categories/delete/{categoryId}', [CategoryController::class, 'destroy']); // Kategori Sil
    // Route::post('subCategories/create/{categoryId}', [SubCategoryController::class, 'store']); // Alt Kategori Oluşturur
    // // Route::put('subCategories/update/{categoryId}/{subCategoryId}', [SubCategoryController::class, 'update']); // Alt Kategori Günceller
    // // Route::delete('subCategories/delete/{categoryId}/{subCategoryId}', [SubCategoryController::class, 'destroy']); // Alt Kategori Sil
    // Route::get("categories/listAllCategories", [CategoryController::class, "allSubCategoriesList"]); // Tüm Kategorileri Getirir


    // Route::get("statistics/dailyAds", [StatisticsController::class, "DailyAds"]);
    // Route::get("statistics/dailyModal", [StatisticsController::class, "DailyModal"]);

});