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


Route::post('login', [UserController::class, 'login']); //TODO : Silinecek
Route::post('register', [UserController::class, 'register']); //TODO : Silinecek

Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);


// ###  KATEGORİ, ALT KATEGORİ APİLERİ ###
// Route::get('categories/', [CategoryController::class, 'index']); // Kategori Listeler Silinecek  //TODO : Silinecek
// Route::get('subCategories/{categoryId}/', [SubCategoryController::class, 'index']); // Alt Kategori Listeler //TODO : Silinecek


// Route::get('categories/list', [CategoryController::class, 'index']);
// Route::get('subCategories/list/{categoryId}', [SubCategoryController::class, 'index']);



// ### GONDERİ APİLERİ ###
// Route::post('posts/list', [PostsController::class, 'listFilterWithPagination']); // El İşi Listeler Filtreler
// Route::get('posts/detail/{postId}', [PostsController::class, 'detail']); // El İşi Detayını Getirir


// ### Şifremi Unuttum APİLERİ ###
// Route::post("forgotPassword", [ForgotPasswordCodesController::class, "forgotPassword"]);  //TODO : Silinecek
// Route::post("checkCode", [ForgotPasswordCodesController::class, "checkCode"]); // Kod kontrol  //TODO : Silinecek
// Route::post("resetPassword", [ForgotPasswordCodesController::class, "resetPassword"]); // Şifre değiştirme  //TODO : Silinecek



// Route::post("user/forgotPassword", [ForgotPasswordCodesController::class, "forgotPassword"]);
// Route::post("user/checkCode", [ForgotPasswordCodesController::class, "checkCode"]);
// Route::post("user/resetPassword", [ForgotPasswordCodesController::class, "resetPassword"]);


// Route::post("copyright/create", [CopyrightMessagesController::class, "create"]); // Telif hakkı mesajı gönderir  //TODO : Silinecek
// Route::post("suggestion/create", [SuggestionMessagesController::class, "create"]); // İstek öneri mesajı gönderir //TODO : Silinecek

// Route::post("messages/copyright/create", [CopyrightMessagesController::class, "create"]); // Telif hakkı mesajı gönderir
// Route::post("messages/suggestion/create", [SuggestionMessagesController::class, "create"]); // İstek öneri mesajı gönderir



// Route::post("translate", [AwsTranslateController::class, "translate"]);
// Route::get("notifications", [NotificationsController::class, "get"]); // Bildirimleri getirir
// Route::put("notifications", [NotificationsController::class, "update"]); // Bildirimleri günceller
// Route::post("pushNotification", [FirebasePushController::class, "SendNotification"]); // Bildirim gönderir
// Route::get("sendNotificationAll", [FirebasePushController::class, "SendNotificationAllUsers"]); 
// Route::get("SendNotificationToTopic", [FirebasePushController::class, "SendNotificationToTopic"]);
// Route::get("rafflePostJoiningUser", [PostsController::class, "rafflePostJoiningUser"]);

Route::middleware(["jwt"])->group(function () {

    // ### GONDERİ APİLERİ ###
    // Route::post('posts/myList', [PostsController::class, 'myList']); // El İşi Listeler Filtreler
    // Route::get('posts/myListCount', [PostsController::class, 'myListCount']); // El İşi Listeler Filtreler

    // ### El İşi APİLERİ ###
    // Route::post('posts/create', [PostsController::class, 'store']); // El İşi Oluşturur
    // Route::put('posts/update/{postId}', [PostsController::class, 'update']); // El İşi Günceller
    // Route::delete('posts/delete/{postId}', [PostsController::class, 'destroy']); // El İşi Sil


    // Route::put('posts/{postId}', [PostsController::class, 'update']);     //Silinecek  //TODO : Silinecek
    // Route::delete('posts/{postId}', [PostsController::class, 'destroy']); //Silinecek  //TODO : Silinecek

    // Route::post('posts/toggleFavorite/{postId}', [FavoritesController::class, 'toggleFavorite']); //Silinecek  //TODO : Silinecek
    // Route::get('posts/favorites', [FavoritesController::class, 'getFavorites']); //Silinecek  //TODO : Silinecek

    // Route::post('favorites/toggleFavorite/{postId}', [FavoritesController::class, 'toggleFavorite']);
    // Route::get('favorites/list', [FavoritesController::class, 'getFavorites']);

    // ### DOSYA APİLERİ ### 
    // Route::post("file", [FilesController::class, "upload"]); // Dosya yükler //TODO : Silinecek
    // Route::delete("file/{fileId}", [FilesController::class, "delete"]); // Dosya siler //TODO : Silinecek

    // Route::post("file/upload", [FilesController::class, "upload"]); // Dosya yükler
    // Route::delete("file/delete/{fileId}", [FilesController::class, "delete"]); // Dosya siler


    ### KULLANICI APİLERİ ###
    Route::get('user', [UserController::class, 'self']); // Kullanıcı bilgilerini getirir //TODO : Silinecek
    Route::put('user', [UserController::class, 'update']); // Kullanıcı bilgilerini günceller //TODO : Silinecek
    Route::delete('user', [UserController::class, 'destroy']); // Kullanıcı siler //TODO : Silinecek
    Route::put("userPassword", [UserController::class, "changePassword"]); // Kullanıcı şifresini günceller //TODO : Silinecek
    Route::post("userProfilePhoto", [UserController::class, "updateProfilePhoto"]); // Profil fotoğrafı ayarlar  //TODO : Silinecek

    Route::get('user/self', [UserController::class, 'self']); // Kullanıcı bilgilerini getirir
    Route::put('user/update', [UserController::class, 'update']); // Kullanıcı bilgilerini günceller
    Route::delete('user/delete', [UserController::class, 'destroy']); // Kullanıcı siler
    Route::put("user/changePassword", [UserController::class, "changePassword"]); // Kullanıcı şifresini günceller

    Route::post("user/profilePhoto", [UserController::class, "updateProfilePhoto"]); // Profil fotoğrafı ayarlar
    Route::put("user/fcmToken", [UserController::class, "updateFcmToken"]); // Fcm token günceller
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