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
                    return response()->error("Kullanıcı hesabı silinmiştir.", "", 400, $request->email);
                }
            }
            if (Hash::check($credentials['password'], $user->password)) {
                $token = Auth::attempt($credentials);
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
                'password.required' => "Şifre alanı zorunludur.",
                'password.min' => "Şifre en az 6 karakter olmalıdır.",
            ];

            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ], $messages);



            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
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
            ];
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                "iban_no" => "nullable|string|max:255",
            ], $messages);
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->iban_no = $request->iban_no;
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

    public function destroy(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'current_password' => 'required|string',
            ]);
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->error("Hatalı şifre girdiniz");
            }
            $user->is_deleted = true;
            $user->save();
            return response()->success(null);
        } catch (\Exception $e) {
            return response()->error('Kullanıcı hesabı silinemedi', $e->getMessage(), 500);
        }
    }
}