<?php

namespace App\Http\Controllers\Web;


use App\CPU\CartManager;
use App\CPU\Helpers;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Color;
use App\Model\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $product->unit_price = Helpers::getProductPrice_pl($product->id)['value'];
        $product->discount = Helpers::getProductPrice_pl($product->id)['discount_price'];
        $product->discount_type = Helpers::getProductPrice_pl($product->id)['discount_type'];
        $str = '';
        $quantity = 0;
        $price = 0;

        if ($request->has('color')) {
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $tax = Helpers::tax_calculation(json_decode($product->variation)[$i]->price, $product['tax'], $product['tax_type']);
                    $discount = Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
                    $price = json_decode($product->variation)[$i]->price - $discount + $tax;
                    $quantity = json_decode($product->variation)[$i]->qty;
                }
            }
        } else {
            $tax = Helpers::tax_calculation($product->unit_price, $product['tax'], $product['tax_type']);
            $discount = Helpers::get_product_discount($product, $product->unit_price);
            $shipping_cost = 0;
            if(\App\Model\BusinessSetting::where('type','show_shipping_calc')->first()->value ?? false){
                $shipping_cost = $product['shipping_cost'];
            }
            $price = $product->unit_price - $discount + $tax + $shipping_cost;
            $quantity = $product->current_stock;
        }

        $show_calculating_price_product = \App\Model\BusinessSetting::where('type','show_calculating_price_product')->first()->value ?? '';
        return [
            'price' => \App\CPU\Helpers::currency_converter($price * ($show_calculating_price_product ? $request->quantity : 1)),
            'discount' => \App\CPU\Helpers::currency_converter($discount),
            'tax' => \App\CPU\Helpers::currency_converter($tax),
            'quantity' => $quantity
        ];
    }

    public function addToCart(Request $request)
    {
        $cart = CartManager::add_to_cart($request);
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        return response()->json($cart);
    }

    public function updateNavCart()
    {
        return response()->json(['data' => view('layouts.front-end.partials.cart')->render()]);
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        $user = Helpers::get_customer();
        if ($user == 'offline') {
            if (session()->has('offline_cart') == false) {
                session()->put('offline_cart', collect([]));
            }
            $cart = session('offline_cart');

            $new_collection = collect([]);
            foreach ($cart as $item) {
                if ($item['id'] !=  $request->key) {
                    $new_collection->push($item);
                }
            }

            session()->put('offline_cart', $new_collection);
            return response()->json($new_collection);
        } else {
            $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
            Cart::where(['id' => $request->key, 'customer_id' => $storeId])->delete();
        }

        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('shipping_method_id');
        session()->forget('order_note');

        return response()->json(['data' => view('layouts.front-end.partials.cart_details')->render()]);
    }

    public function deleteCart(Request $request)
    {
        CartManager::cart_clean();
        Toastr::success(Helpers::translate('Cart cleared successfully.'));
        return redirect(route('home'));
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        if ($response['status'] == 0) {
            return response()->json($response);
        }

        return response()->json(view('layouts.front-end.partials.cart_details')->render());
    }
}
