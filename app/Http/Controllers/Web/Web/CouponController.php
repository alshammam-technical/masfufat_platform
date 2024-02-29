<?php

namespace App\Http\Controllers\Web;

use App\CPU\CartManager;
use App\CPU\Helpers;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Coupon;
use App\Model\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $couponLimit = Order::where('customer_id', $storeId)
            ->where('coupon_code', $request['code'])->count();

        $coupon = Coupon::where(['code' => $request['code']])
            ->where('limit', '>', $couponLimit)
            ->where('status', '=', 1)
            ->whereDate('start_date', '<=', date('y-m-d'))
            ->whereDate('expire_date', '>=', date('y-m-d'))
            ->first();

        if ($coupon) {
            $total = 0;
            foreach (CartManager::get_cart() as $cart) {
                $product_subtotal = $cart['price'] * $cart['quantity'];
                $total += $product_subtotal;
                $cart_group_id = $cart->cart_group_id;
            }
            if ($total >= $coupon['min_purchase']) {
                if ($coupon['discount_type'] == 'percentage') {
                    $discount = (($total / 100) * $coupon['discount']) > $coupon['max_discount'] ? $coupon['max_discount'] : (($total / 100) * $coupon['discount']);
                } else {
                    $discount = $coupon['discount'];
                }

                session()->put('coupon_code', $request['code']);
                session()->put('coupon_discount', $discount);

                $c_cart = Cart::where('customer_id',$storeId)->whereNotNull('offer')->first();
                if(!$c_cart){
                    $c_cart = new Cart();
                    $c_cart->offer = ["cart_discount" => "on"];
                }
                $c_cart->customer_id = $storeId;
                $c_cart->cart_group_id = $cart_group_id;
                $c_cart->coupon_code = $request['code'];
                $c_cart->save();
                return response()->json([
                    'status' => 1,
                    'discount' => Helpers::currency_converter($discount),
                    'total' => Helpers::currency_converter($total - $discount),
                    'messages' => ['0' => 'Coupon Applied Successfully!']
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'messages' => ['0' => 'Invalid Coupon']
        ]);
    }

    public function remove(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        Cart::where('customer_id',$storeId)->where('coupon_code',session('coupon_code'))->whereNotNull('offer')->delete();
        Cart::where('customer_id',$storeId)->where('coupon_code',session('coupon_code'))->update(['coupon_code'=>null,'offer'=>null]);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        return back();
    }
}
