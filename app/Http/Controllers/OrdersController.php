<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    //

    public function userOrderlist(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->with('product')->get();
        return response()->success($orders);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'product_id' => 'required|integer:exists:products,id',
        ]);
        $product_id = $request->product_id;
        $product = Products::find($product_id);
        if (!$product) {
            return response()->error("Ürün bulunamadı.", "", 400);
        }
        $user_coin_count = $user->coin_count;
        $product_coin = $product->coin;
        if ($user_coin_count < $product_coin) {
            return response()->error("Yetersiz bakiye.", "", 400);
        } else {
            $discount_coupon = $this->generateRandomCoupon();
            $order = $user->orders()->create([
                "product_id" => $product_id,
                "discount_coupon" => $discount_coupon
            ]);
            $user->coin_count = $user_coin_count - $product_coin;
            $user->save();
        }
        return response()->success($order);
    }

    private function generateRandomCoupon()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $coupon = '';
        for ($i = 0; $i < 10; $i++) {
            $coupon .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $coupon;
    }

}
