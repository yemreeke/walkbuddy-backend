<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $lang = request()->header('Accept-Language') ?? 'tr';
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return response()->error("E-posta adresine kayıtlı kullanıcı bulunamadı!", "", 400, $request->email);
            }
            $isDelete = User::where('email', $credentials['email'])->where('is_deleted', true)->first();
            if ($isDelete) {
                if (Hash::check($credentials['password'], $isDelete->password)) {
                    // Kullanıcının şifresi doğruysa ve hesabı silinmişse uygun bir yanıt dönebilirsiniz.
                    return response()->error("Kullanıcı hesabı silinmiştir.", "", 400, $request->email);
                } else {
                    // Kullanıcının şifresi yanlışsa hata mesajı dönebilirsiniz.
                    return response()->error("Hatalı e-posta veya şifre girilmiştir.", "", 400, $request->email);
                }
            }
            if (Hash::check($credentials['password'], $user->password)) {
                $token = Auth::attempt($credentials);
                $user->makeHidden(['fcm_token']);
                $data = [
                    'user' => $user,
                    'token' => $token,
                ];
                return response()->success($data, "Giriş Başarılı");
            } else {
                return response()->error("Hatalı e-posta veya şifre girilmiştir.", "", 400, $request->email);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first()); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Giriş Başarısız', $e->getMessage(), 500);
        }
    }

    public function register(Request $request)
    {
        try {

            $messages = [
                'name.required' => "Ad alanı zorunludur.",
                'surname.required' => "Soyad alanı zorunludur.",
                'email.required' => "E-posta alanı zorunludur.",
                'email.email' => "Geçerli bir e-posta adresi giriniz.",
                'email.max' => "E-posta alanı en fazla 255 karakter olmalıdır.",
                'email.unique' => "Bu e-posta adresi zaten kullanılmıştır.",
                'username.required' => "Kullanıcı adı alanı zorunludur.",
                'username.min' => "Kullanıcı adı en az 6 karakter olmalıdır.",
                'username.max' => "Kullanıcı adı en fazla 255 karakter olmalıdır.",
                'username.unique' => "Bu kullanıcı adı zaten kullanılmıştır.",
                'password.required' => "Şifre alanı zorunludur.",
                'password.min' => "Şifre en az 6 karakter olmalıdır.",

            ];

            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|min:6|max:255|unique:users',
                'password' => 'required|string|min:6',

            ], $messages);





            // $defaultPhoto = env("UPLOAD_SITE_URL") . 'profile/default.png';
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'profile_photo' => "",
                "is_accepted_kvkk" => $request->is_accepted_kvkk,
                "is_accepted_agreement" => $request->is_accepted_agreement,
            ]);
            $token = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            $user->makeHidden(['fcm_token']);
            $data = [
                'user' => $user,
                'token' => $token,
            ];
            return response()->success($data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first(), "", 400); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Kayıt Başarısız', $e->getMessage(), 500);
        }

    }

    public function self()
    {
        try {
            $user = Auth::user();
            $user->makeHidden(['fcm_token', "platform"]);
            return response()->success($user);
        } catch (\Exception $e) {
            return response()->error('Kullanıcı bilgileri alınamadı', $e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $messages = [
                'name.required' => "Ad alanı zorunludur.",
                'name.max' => "Ad alanı en fazla 255 karakter olmalıdır.",
                'surname.required' => "Soyad alanı zorunludur.",
                'surname.max' => "Soyad alanı en fazla 255 karakter olmalıdır.",
                'email.required' => "E-posta alanı zorunludur.",
                'email.email' => "Geçerli bir e-posta adresi giriniz.",
                'email.max' => "E-posta alanı en fazla 255 karakter olmalıdır.",
                'email.unique' => "Bu e-posta adresi zaten kullanılmıştır.",
                'username.required' => "Kullanıcı adı alanı zorunludur.",
                'username.min' => "Kullanıcı adı en az 6 karakter olmalıdır.",
                'username.max' => "Kullanıcı adı en fazla 255 karakter olmalıdır.",
                'username.unique' => "Bu kullanıcı adı zaten kullanılmıştır.",
            ];
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'username' => 'required|string|min:6|max:255|unique:users,username,' . $user->id,
            ], $messages);
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->save();
            return response()->success($user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first(), "", 400); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Kullanıcı bilgileri güncellenemedi', $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
            ], [
                'current_password.required' => "Mevcut şifre alanı boş bırakılamaz.",
                'new_password.required' => "Yeni şifre alanı boş bırakılamaz.",
                'new_password.min' => "Yeni şifre en az 6 karakter olmalıdır.",
            ]);

            $user = Auth::user();
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->error("Mevcut şifreniz yanlıştır.");
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->success(null);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->error($e->validator->getMessageBag()->first(), "", 400); // Validasyon hataları
        } catch (\Exception $e) {
            return response()->error('Şifre güncellenemedi', $e->getMessage(), 500);
        }
    }

    // public function updateProfilePhoto(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $request->validate([
    //             'file' => 'required|mimes:jpg,png,jpeg|max:5048',
    //         ]);

    //         $userProfileFolder = public_path('uploads/profile/');
    //         if (!File::isDirectory($userProfileFolder)) {
    //             File::makeDirectory($userProfileFolder, 0777, true, true);
    //         }

    //         $extension = $request->file->extension();
    //         $fileName = Str::uuid() . '.' . $extension;
    //         $fileSize = $request->file->getSize();
    //         // Dosyayı profil klasörüne taşı
    //         $file = Files::where('user_id', $user->id)->where("is_profile_photo", true)->first();
    //         if (!$file) {
    //             $file = new Files();
    //             $file->user_id = $user->id;
    //         } else {
    //             // Eski dosyayı sil
    //             unlink(public_path('uploads/profile') . '/' . $file->name);
    //         }
    //         $url = env("UPLOAD_SITE_URL") . 'profile/' . $fileName;
    //         $request->file->move(public_path('uploads/profile'), $fileName);
    //         $file->name = $fileName;
    //         $file->path = $url;
    //         $file->type = 'png';
    //         $file->size = $fileSize;
    //         $file->is_profile_photo = true;
    //         $file->save();
    //         $user->profile_photo = $url;
    //         $user->save();
    //         return response()->success($file->path);
    //     } catch (\Throwable $th) {
    //         return response()->error("Profil Fotoğrafı Yüklenemedi", $th->getMessage(), 500);
    //     }
    // }

    public function updateFcmToken(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                "fcm_token" => "string|nullable",
                "platform" => "string|nullable",
            ]);
            $user->fcm_token = $request->fcm_token;
            $user->platform = $request->platform;
            $user->save();
            return response()->success(null, "FCM Token güncellenmiştir.");
        } catch (\Throwable $th) {
            return response()->error("FCM Token güncellenemedi!", $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'current_password' => 'required|string',
            ]);
            // $user->password -> Hashli şifredir.
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->error("Hatalı şifre girdiniz");
            }
            // "is_deleted" durumunu değiştir
            $user->is_deleted = true; // veya true, duruma göre değiştirin
            $user->save();
            $posts = $user->posts()->get();
            foreach ($posts as $post) {
                $post->is_deleted = true;
                $post->favorites()->delete();
                $post->save();
            }
            return response()->success(null);
        } catch (\Exception $e) {
            return response()->error('Kullanıcı hesabı silinemedi', $e->getMessage(), 500);
        }
    }
}