<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Token kontrolü yapın
        if (!Auth::guard('api')->check()) {
            return response()->json(
                [
                    "status" => 401,
                    'message' => 'Yetkisiz erişim, token geçersizdir.',
                ],
                401
            );
        }

        $user = Auth::guard('api')->user();
        if ($user->is_deleted) {
            return response()->json(
                [
                    "status" => 401,
                    'message' => 'Kullanıcı Bulunamadı (Kulllanıcı Silinmiştir).',
                ],
                401
            );
        }
        return $next($request);
    }
}