<?php

namespace App\Http\Controllers\Web;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\CPU\ProductManager;
use App\CPU\CartManager;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Cart;
use App\Model\CartShipping;
use App\Model\Category;
use App\Model\Contact;
use App\Model\DealOfTheDay;
use App\Model\DeliveryZipCode;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\HelpTopic;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;
use App\Model\OfflinePaymentMethod;
use App\Model\Seller;
use App\Model\Subscription;
use App\Model\Shop;
use App\Model\Order;
use App\Model\Translation;
use App\Traits\CommonTrait;
use App\User;
use App\Model\Wishlist;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Model\ShippingType;
use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use App\CPU\CustomerManager;
use App\CPU\ImageManager;
use App\CPU\SallaHelpers;
use App\external_orders;
use App\Http\Controllers\Customer\SystemController;
use App\Http\Controllers\MyFatoorahController;
use App\Model\Coupon;
use App\Model\Currency;
use App\Model\Notification;
use App\Model\ShippingMethod;
use App\Package;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class WebController extends Controller
{

    public $mfObj;
    public $apiURL;
    public $apiKey;
    public $ipPostFields;
    public $paymentMethods;
    public $paymentMethodId;
    public $postFields;
    public $data;
    public $invoiceId;
    public $paymentURL;
    public $cardInfo;
    public $directData;
    public $paymentId;
    public $paymentLink;



    use CommonTrait;
    public function maintenance_mode()
    {
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;
        if ($maintenance_mode) {
            return view('web-views.maintenance-mode');
        }
        return redirect()->route('home');
    }


    public function home()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $store = User::find($storeId);
        if (((auth('customer')->check() || auth('delegatestore')->check())) && !$store->is_active) {
            return redirect(route('subscriptions'));
        }
        $products = Product::active()->get();
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) use ($products) {
            $pi = 0;
            $dataproducts = [];
            foreach ($products as $product) {
                $a = null;
                if (isset(json_decode($product['category_ids'])[0])) {
                    if (isset(json_decode($product['category_ids'])[0]->id)) {
                        $a = json_decode($product['category_ids'])[0]->id;
                    }
                }
                if (in_array($data['id'], explode(',', $a))) {
                    $dataproducts[$pi] = $product;
                    $pi = $pi + 1;
                }
            }
            $data['products'] = $dataproducts;
        });
        //products based on top seller
        $top_sellers = Seller::approved()->with('shop')
            ->withCount(['orders'])->orderBy('orders_count', 'DESC')->take(12)->get();
        //end

        //feature products finding based on selling
        $featured_products = Product::with(['reviews'])->active()
            ->where('featured', 1)
            ->withCount(['order_details'])
            //->orderBy('order_details_count', 'DESC')
            ->take(12)
            ->get();
        //end


        $latest_products = Product::with(['reviews'])->active()->orderBy('id', 'desc')->take(8)->get();
        $categories = Category::where('position', 0)->priority()->take(11)->get();
        $brands = Brand::active()->take(15)->get();
        //best sell product
        $bestSellProduct = OrderDetail::with('product.reviews')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();
        //Top rated
        $topRated = Review::with('product')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('AVG(rating) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();

        if ($bestSellProduct->count() == 0) {
            $bestSellProduct = $latest_products;
        }

        if ($topRated->count() == 0) {
            $topRated = $bestSellProduct;
        }
        $deal_of_the_day = DealOfTheDay::join('products', 'products.id', '=', 'deal_of_the_days.product_id')->select('deal_of_the_days.*', 'products.unit_price')->where('products.status', 1)->where('deal_of_the_days.status', 1)->first();
        if (auth('customer')->check() || session('user_type') == 'delegate') {
            return view('web-views.home', compact('featured_products', 'topRated', 'bestSellProduct', 'latest_products', 'categories', 'brands', 'deal_of_the_day', 'top_sellers', 'home_categories', 'brand_setting'));
        }
        return view('web-views.landing');
    }

    public function flash_deals($id)
    {
        $deal = FlashDeal::with(['products.product.reviews', 'products.product' => function ($query) {
            $query->active();
        }])
            ->where(['id' => $id, 'status' => 1])
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->first();

        $discountPrice = FlashDealProduct::with(['product'])->whereHas('product', function ($query) {
            $query->active();
        })->get()->map(function ($data) {
            $data->product->unit_price = Helpers::getProductPrice_pl($data->product->id)['value'];
            $data->product->discount = Helpers::getProductPrice_pl($data->product->id)['discount_price'];
            $data->product->discount_type = Helpers::getProductPrice_pl($data->product->id)['discount_type'];
            return [
                'discount' => $data->discount,
                'sellPrice' => $data->product->unit_price,
                'discountedPrice' => $data->product->unit_price - $data->discount,

            ];
        })->toArray();


        // dd($deal->toArray());

        if (isset($deal)) {
            return view('web-views.deals', compact('deal', 'discountPrice'));
        }
        Toastr::warning(Helpers::translate('not_found'));
        return back();
    }

    public function search_shop(Request $request)
    {
        $key = explode(' ', $request['shop_name']);
        $sellers = Shop::where(function ($q) use ($request) {
            $q->orWhere('name', 'like', "%".$request['shop_name']."%")
            ->orWhere('name', '=', $request['shop_name']);
        })->whereHas('seller', function ($query) {
            return $query->where(['status' => 'approved']);
        });
        $sellers = $sellers->whereHas('seller', function ($query) {
            return $query->where('show_sellers_section', true)->approved();
        });
        $cnt = $sellers->count();
        $sellers = $sellers->paginate(30);
        return view('web-views.sellers', compact('sellers','cnt'));
    }

    public function all_categories()
    {
        $categories = Category::all();
        return view('web-views.categories', compact('categories'));
    }

    public function categories_by_category($id)
    {
        $category = Category::with(['childes.childes'])->where('id', $id)->first();
        return response()->json([
            'view' => view('web-views.partials._category-list-ajax', compact('category'))->render(),
        ]);
    }

    public function all_brands()
    {
        $brands = Brand::active()->paginate(24);
        return view('web-views.brands', compact('brands'));
    }

    public function getChildren($object, $id = null)
    {
        $r = DB::table("$object")->where('parent_id', $id)->where('enabled', 1)->get();
        $res = "<option disabled selected></option>";
        foreach ($r as $rr) {
            $res .= "<option value='" . $rr->id . "'>" . \App\CPU\Helpers::getItemName($object, 'name', $rr->id) . "</option>";
        }
        return $res;
    }

    public function all_sellers()
    {
        if(!Helpers::store_module_permission_check('store.sellers.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        if (BusinessSetting::where('type', 'show_sellers_section')->first()->value ?? '') {
            $business_mode = Helpers::get_business_settings('business_mode');
            if (isset($business_mode) && $business_mode == 'single') {
                Toastr::warning(Helpers::translate('access_denied!!'));
                return back();
            }
            $sellers = Shop::whereHas('seller', function ($query) {
                return $query->where('show_sellers_section', true)->approved();
            });
            $cnt = $sellers->count();
            $sellers = $sellers->paginate(24);
            return view('web-views.sellers', compact('sellers','cnt'));
        } else {
            return abort(404);
        }
    }

    public function seller_profile($id)
    {
        if(!Helpers::store_module_permission_check('store.seller_details.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        if (BusinessSetting::where('type', 'show_sellers_section')->first()->value ?? '') {
            $seller_info = Seller::find($id);
            return view('web-views.seller-profile', compact('seller_info'));
        } else {
            return abort(404);
        }
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        // $result = ProductManager::search_products_web($request['name']);
        // $products = $result['products'];
        $products = null;

        if ($products == null) {
            $result = ProductManager::translated_product_search_web($request['name']);
            $products = $result['products'];
        }

        return response()->json([
            'result' => view('web-views.partials._search-result', compact('products'))->render(),
        ]);
    }

    public function checkout_details(Request $request)
    {
        $cart_group_ids = CartManager::get_cart_group_ids();
        $shippingMethod = Helpers::get_business_settings('shipping_method');

        $physical_product_view = false;
        foreach ($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product_view = true;
                }
            }
        }

        foreach ($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();

            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }
            if ($physical_product) {
                foreach ($carts as $cart) {
                    if ($shippingMethod == 'inhouse_shipping') {
                        $admin_shipping = ShippingType::where('seller_id', 0)->first();
                        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                    } else {
                        if ($cart->seller_is == 'admin') {
                            $admin_shipping = ShippingType::where('seller_id', 0)->first();
                            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                        } else {
                            $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                            $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                        }
                    }

                    if ($physical_product && $shipping_type == 'order_wise') {
                        $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                        if (!isset($cart_shipping)) {
                            Toastr::info(Helpers::translate('select_shipping_method_first'));
                            return redirect('shop-cart');
                        }
                    }
                }
            }
        }

        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        if ($country_restrict_status) {
            $countries = $this->get_delivery_country_array();
        } else {
            $countries = COUNTRIES;
        }

        if ($zip_restrict_status) {
            $zip_codes = DeliveryZipCode::all();
        } else {
            $zip_codes = 0;
        }

        if (!file_exists('reqs/computer-checkouts')) {
            mkdir('reqs/computer-checkouts', 0777, true);
        }
        $mac_device = false;
        if (str_contains($request->headers->get('User-Agent'), 'iPhone')) {
            $ordered_using = "Web";
            $mac_device = true;
        }
        $myfile = fopen("reqs/computer-checkouts/checkout_payment-" . Carbon::now()->format('YmdHms') . ".txt", "w") or die("Unable to open file!");
        fwrite($myfile, "$request");
        fclose($myfile);
        $cart_group_ids = CartManager::get_cart_group_ids();
        $shippingMethod = Helpers::get_business_settings('shipping_method');

        $physical_products[] = false;
        foreach ($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();
            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }
            $physical_products[] = $physical_product;
        }
        unset($physical_products[0]);

        $cod_not_show = in_array(false, $physical_products);

        foreach ($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();

            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }

            if ($physical_product) {
                foreach ($carts as $cart) {
                    if ($shippingMethod == 'inhouse_shipping') {
                        $admin_shipping = ShippingType::where('seller_id', 0)->first();
                        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                    } else {
                        if ($cart->seller_is == 'admin') {
                            $admin_shipping = ShippingType::where('seller_id', 0)->first();
                            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                        } else {
                            $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                            $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                        }
                    }
                    if ($shipping_type == 'order_wise') {
                        $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                        if (!isset($cart_shipping)) {
                            Toastr::info(Helpers::translate('select_shipping_method_first'));
                            return redirect('shop-cart');
                        }
                    }
                }
            }
        }
        $payment_gateways_list = [];
        $payment_gateways_list = MyFatoorahController::getPMs();
        $plan_id = $request->plan_id;

        if (count($cart_group_ids) > 0) {
            if($request->error){
                Toastr::error(Helpers::translate($request->error));
            }
            return view('web-views.checkout-shipping', compact('physical_product_view', 'zip_codes', 'country_restrict_status', 'zip_restrict_status', 'countries', 'cod_not_show', 'payment_gateways_list', 'mac_device', 'plan_id'));
        }

        Toastr::info(Helpers::translate('no_items_in_basket'));
        return redirect('/');
    }

    public function checkout_payment(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if (
            (!auth('customer')->check() || !auth('delegatestore')->check() || Cart::where(['customer_id' => $storeId])->count() < 1)
            && (!Helpers::get_business_settings('guest_checkout') || !session()->has('guest_id') || !session('guest_id'))
        ){
            Toastr::error(translate('invalid_access'));
            return redirect('/');
        }

        $cart_group_ids = CartManager::get_cart_group_ids();
        $shippingMethod = Helpers::get_business_settings('shipping_method');


        $verify_status = OrderManager::minimum_order_amount_verify($request);

        if($verify_status['status'] == 0){
            Toastr::info(translate('check_Minimum_Order_Amount_Requirment'));
            return redirect()->route('shop-cart');
        }

        $cartItems = Cart::where(['customer_id' => $storeId])->withCount(['all_product'=>function($query){
            return $query->where('status', 0);
        }])->get();
        foreach($cartItems as $cart)
        {
            if(isset($cart->all_product_count) && $cart->all_product_count != 0)
            {
                Toastr::info(translate('check_Cart_List_First'));
                return redirect()->route('shop-cart');
            }
        }

        $physical_products[] = false;
        foreach($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();
            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }
            $physical_products[] = $physical_product;
        }
        unset($physical_products[0]);

        $cod_not_show = in_array(false, $physical_products);

        foreach($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();

            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }

            if($physical_product) {
                foreach ($carts as $cart) {
                    if ($shippingMethod == 'inhouse_shipping') {
                        $admin_shipping = ShippingType::where('seller_id', 0)->first();
                        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                    } else {
                        if ($cart->seller_is == 'admin') {
                            $admin_shipping = ShippingType::where('seller_id', 0)->first();
                            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                        } else {
                            $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                            $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                        }
                    }
                    if ($shipping_type == 'order_wise') {
                        $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                        if (!isset($cart_shipping)) {
                            Toastr::info(translate('select_shipping_method_first'));
                            return redirect('shop-cart');
                        }
                    }
                }
            }
        }

        $order = Order::find(session('order_id'));
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $order_wise_shipping_discount = CartManager::order_wise_shipping_discount();
        $get_shipping_cost_saved_for_free_delivery = CartManager::get_shipping_cost_saved_for_free_delivery();
        $amount = CartManager::cart_grand_total() - $coupon_discount - $order_wise_shipping_discount - $get_shipping_cost_saved_for_free_delivery;
        $inr=Currency::where(['symbol'=>'₹'])->first();
        $usd=Currency::where(['code'=>'USD'])->first();
        $myr=Currency::where(['code'=>'MYR'])->first();

        $cash_on_delivery = Helpers::get_business_settings('cash_on_delivery');
        $digital_payment = Helpers::get_business_settings('digital_payment');
        $wallet_status = Helpers::get_business_settings('wallet_status');
        $offline_payment = Helpers::get_business_settings('offline_payment');

        $payment_gateways_list = Helpers::payment_gateways();

        $offline_payment_methods = OfflinePaymentMethod::where('status', 1)->get();
        $payment_published_status = config('get_payment_publish_status');
        $payment_gateway_published_status = isset($payment_published_status[0]['is_published']) ? $payment_published_status[0]['is_published'] : 0;

        if (session()->has('address_id') && session()->has('billing_address_id') && count($cart_group_ids) > 0) {
            return view(
                'web-views.payment',
                compact(
                    'cod_not_show','order','cash_on_delivery','digital_payment','offline_payment',
                    'wallet_status','coupon_discount','amount','inr','usd','myr','payment_gateway_published_status','payment_gateways_list','offline_payment_methods'
                ));
        }

        Toastr::error(translate('incomplete_info'));
        return back();
    }

    public function checkout_complete(Request $request)
    {
        if($request->payment_method !== "delayed"){
            $request->validate([
                'attachment' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            ], [
                'attachment.required' => Helpers::translate('Please attach the receipt image'),
                'attachment.mimes' => Helpers::translate('Attachment format should be image or pdf'),
            ]);
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if (isset($request['plan_id'])) {
            $user = Helpers::get_customer($request);
            //$sub = Subscription::where(['user_id'=>$user->id])->whereIn('status',['paid','active'])->orderBy('id','desc')->first();
            //$sub->status = "upgraded";
            //$sub->save();

            $sub = new Subscription();
            $sub->user_id = $storeId;
            $sub->package_id = $request['plan_id'];
            $period = Package::find($request['plan_id'])->period;
            $sub->amount = Package::find($request['plan_id'])->price;
            $sub->period = $period;
            $sub->expiry_date = Carbon::now()->addDays($period);
            $sub->attachment = ImageManager::upload('user/', ($request->attachment)->extension(), $request->attachment);
            $sub->payment_method = $request->payment_method.'-'.$request->holder_name;
            $sub->status = "pending";
            $sub->save();
            //$user = User::find(auth('customer')->id());
            //$user->subscription = $request['plan_id'];
            //$store_informations = $user->store_informations;
            //$store_informations['pricing_level'] = Package::find($request['plan_id'])->pricing_level;
            //$user->store_informations = $store_informations;
            //$user->is_active = 1;
            //$user->save();
            $user = User::find($user->id);
            if (auth('customer')->loginUsingId($user->id, true) || auth('delegatestore')->loginUsingId($user->id, true)) {
                $customer = User::find($storeId);
                $wish_list = Wishlist::whereHas('wishlistProduct', function ($q) {
                    return $q;
                })->where('customer_id', $customer->id)->pluck('product_id')->toArray();
                $user->login_code = null;
                $user->save();
                session()->put('wish_list', $wish_list);
                CartManager::cart_to_db();
            } else {
                $user->save();
            }
            Toastr::info(Helpers::translate('Payment information has been sent successfully. We will confirm your subscription soon!'));
            return redirect('/');
        }
        $address_id = session('address_id') ? session('address_id') : null;
        if(!$address_id){
            Toastr::error('Please select shipping address!');
            return back();
        }
        if ($request->payment_method !== 'cash_on_delivery' && $request->payment_method !== 'bank_transfer' && $request->payment_method !== 'delayed') {
            return back()->with('error', 'Something went wrong!');
        }
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        $cart_group_ids = CartManager::get_cart_group_ids();
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $physical_product = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $physical_product = true;
            }
        }

        if ($physical_product) {
            foreach ($cart_group_ids as $group_id) {
                $data = [
                    'payment_method' => $request->payment_method,
                    'order_status' => 'new',
                    'payment_status' => 'unpaid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id,
                    'request' => $request,
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CartManager::cart_clean();


            return view('web-views.checkout-complete');
        }
        return back()->with('error', 'Something went wrong!');
    }
    public function checkout_complete_wallet(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if (isset($request['plan_id'])) {
            $cartTotal = Package::find($request['plan_id'])->price;
            $user = Helpers::get_customer($request);
            if ($cartTotal > $user->wallet_balance) {
                Toastr::warning(Helpers::translate('inefficient balance in your wallet to pay for this order!!'));
                return back();
            }
            $sub = Subscription::where(['user_id' => $user->id])->whereIn('status', ['paid', 'active'])->orderBy('id', 'desc')->first();
            if (!$sub) {
                $sub = Subscription::find($request['plan_id']);
            }
            if($sub){
                $sub->status = "upgraded";
                $sub->save();
            }

            $sub = new Subscription();
            $sub->user_id = $storeId;
            $sub->package_id = $request['plan_id'];
            $sub->payment_method = "customer wallet";
            $sub->period = Package::find($request['plan_id'])->period;
            $sub->amount = Package::find($request['plan_id'])->price;
            $period = Package::find($request['plan_id'])->period;
            $sub->expiry_date = Carbon::now()->addDays($period);
            $sub->status = "paid";
            $sub->save();
            $user = User::find($storeId);
            $user->subscription = $request['plan_id'];
            $store_informations = $user->store_informations;
            $store_informations['pricing_level'] = Package::find($request['plan_id'])->pricing_level;
            $user->store_informations = $store_informations;
            $user->is_active = 1;
            $user->save();
            $user = User::find($user->id);
            CustomerManager::create_wallet_transaction($user->id, $cartTotal, 'subscription', 'subscription payment');
            CartManager::cart_clean();
            Toastr::success(Helpers::translate('Plan activated successfully!'));
            if (auth('customer')->loginUsingId($user->id, true)  || auth('delegatestore')->loginUsingId($user->id, true)) {
                $customer = User::find($storeId);
                $wish_list = Wishlist::whereHas('wishlistProduct', function ($q) {
                    return $q;
                })->where('customer_id', $customer->id)->pluck('product_id')->toArray();
                $user->login_code = null;
                $user->save();
                session()->put('wish_list', $wish_list);
                CartManager::cart_to_db();
            } else {
                $user->save();
            }
            Toastr::success(Helpers::translate('Plan activated successfully!'));
            session()->forget('exp_notify_days');
            return redirect('/');
        }
        $address_id = session('address_id') ? session('address_id') : null;
        $cartTotal = CartManager::cart_grand_total();
        $user = Helpers::get_customer($request);
        if ($cartTotal > $user->wallet_balance) {
            Toastr::warning(Helpers::translate('inefficient balance in your wallet to pay for this order!!'));
            return back();
        } else {
            $unique_id = OrderManager::gen_unique_id();
            $order_ids = [];
            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $data = [
                    'payment_method' => 'pay_by_wallet',
                    'order_status' => 'new',
                    'payment_status' => 'paid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id,
                    'request' => $request,
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CustomerManager::create_wallet_transaction($user->id, $cartTotal, 'order_place', 'order payment');
            CartManager::cart_clean();
        }

        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }
        return view('web-views.checkout-complete');
    }

    public function order_placed()
    {
        return view('web-views.checkout-complete');
    }

    public function shop_cart(Request $request)
    {
        if(!Helpers::store_module_permission_check('store.home.show_cart')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        // def shipping low cost
        $choosen_shipping= CartShipping::where(['cart_group_id'=>CartManager::get_cart_group_ids()[0]])->first();
        if(!$choosen_shipping){
            $shipping = ShippingMethod::where(['status' => 1])->where(['creator_type' => 'admin'])->orderBy('cost','asc')->first();
            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $myRequest = new \Illuminate\Http\Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['id' => $shipping->id]);
                $myRequest->request->add(['cart_group_id' => $group_id]);
                SystemController::insert_into_cart_shipping($myRequest);
            }
        }
        // def shipping low cost end
        $c = Cart::where(['customer_id' => $storeId])
        ->whereNotNull("offer")->first();
        $coupon = Coupon::where(['code' => $c['coupon_code'] ?? null])->first();
        if((!session('coupon_code') && $coupon) || ($coupon && $coupon->discount !== session('coupon_discount'))){
            session()->put('coupon_code', $coupon->code);
            session()->put('coupon_discount', $coupon->discount);
        }
        if ((auth('customer')->check() || auth('delegatestore')->check()) && Cart::where(['customer_id' => $storeId])->whereHas('product')->count() > 0) {
            return view('web-views.shop-cart');
        }
        Toastr::info(Helpers::translate('no_items_in_basket'));
        return redirect('/');
    }

    //for seller Shop

    public function seller_shop(Request $request, $id)
    {
        if(!Helpers::store_module_permission_check('store.sellerview.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        if (!(BusinessSetting::where('type', 'show_sellers_section')->first()->value ?? '')) {
            return abort(404);
        }
        $business_mode = Helpers::get_business_settings('business_mode');

        $active_seller = Seller::approved()->find($id);

        if (($id != 0) && empty($active_seller)) {
            Toastr::warning(Helpers::translate('not_found'));
            return redirect('/');
        }

        if ($id != 0 && $business_mode == 'single') {
            Toastr::error(Helpers::translate('access_denied!!'));
            return back();
        }
        $product_ids = Product::active()
            ->when($id == 0, function ($query) {
                return $query->where(['added_by' => 'admin']);
            })
            ->when($id != 0, function ($query) use ($id) {
                return $query->where(['added_by' => 'seller'])
                    ->where('user_id', $id);
            })
            ->pluck('id')->toArray();


        $avg_rating = Review::whereIn('product_id', $product_ids)->avg('rating');
        $total_review = Review::whereIn('product_id', $product_ids)->count();
        if ($id == 0) {
            $total_order = Order::where('seller_is', 'admin')->where('order_type', 'default_type')->count();
        } else {
            $seller = Seller::find($id);
            $total_order = $seller->orders->where('seller_is', 'seller')->where('order_type', 'default_type')->count();
        }


        //finding category ids
        $products = Product::whereIn('id', $product_ids)->paginate(12);

        $category_info = [];
        foreach (Product::whereIn('id', $product_ids)->get() as $product) {
            array_push($category_info, $product['category_ids']);
        }

        $category_info_decoded = [];
        foreach ($category_info as $info) {
            array_push($category_info_decoded, json_decode($info));
        }

        $category_ids = [];
        foreach ($category_info_decoded as $decoded) {
            foreach ($decoded as $info) {
                array_push($category_ids, $info->id);
            }
        }

        $categories = [];
        foreach ($category_ids as $category_id) {
            $category = Category::with(['childes.childes'])->where('position', 0)->find($category_id);
            if ($category != null) {
                array_push($categories, $category);
            }
        }
        $categories = array_unique($categories);
        //end

        //products search
        if ($request->product_name) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->where('name', 'like', $request->product_name . '%')
                ->paginate(12);
        } elseif ($request->category_id) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->whereJsonContains('category_ids', [
                    ['id' => strval($request->category_id)],
                ])->paginate(12);
        }

        if ($id == 0) {
            $shop = [
                'id' => 0,
                'name' => Helpers::get_business_settings('company_name'),
            ];
        } else {
            $shop = Shop::where('seller_id', $id)->first();
            if (isset($shop) == false) {
                Toastr::error(Helpers::translate('shop_does_not_exist'));
                return back();
            }
        }
        $total_product = $products->count();
        if ($request['lazy']) {
            return view('web-views.products._ajax-products', compact('products'));
        }
        return view('web-views.shop-page', compact('products', 'shop', 'categories','id','total_product'))
            ->with('seller_id', $id)
            ->with('total_review', $total_review)
            ->with('avg_rating', $avg_rating)
            ->with('total_order', $total_order);
    }

    //ajax filter (category based)
    public function seller_shop_product(Request $request, $id)
    {
        if (!(BusinessSetting::where('type', 'show_sellers_section')->first()->value ?? '')) {
            return abort(404);
        }
        $products = Product::active()->with('shop')->where(['added_by' => 'seller'])
            ->where('user_id', $id)
            ->whereJsonContains('category_ids', [
                ['id' => strval($request->category_id)],
            ])
            ->paginate(12);
        $shop = Shop::where('seller_id', $id)->first();
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render(),
            ], 200);
        }

        return view('web-views.shop-page', compact('products', 'shop'))->with('seller_id', $id);
    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        $order_details = OrderDetail::where('product_id', $product->id)->get();
        $wishlists = Wishlist::where('product_id', $product->id)->get();
        $countOrder = count($order_details);
        $countWishlist = count($wishlists);
        $relatedProducts = Product::with(['reviews'])->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._quick-view-data', compact('product', 'countWishlist', 'countOrder', 'relatedProducts'))->render(),
        ]);
    }

    public function product(Request $request, $slug)
    {
        if(!Helpers::store_module_permission_check('store.products_details.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $product = Product::with(['reviews'])->where('slug', $slug)->first();
        $product['discount'] = Helpers::getProductPrice_pl($product->id ?? 0,$storeId)['discount_price'] ?? 0;
        $product['discount_price'] = Helpers::getProductPrice_pl($product->id ?? 0)['discount_price'] ?? 0;
        $product['discount_type'] = Helpers::getProductPrice_pl($product->id ?? 0)['discount_type'] ?? 0;
        $product['unit_price'] = Helpers::getProductPrice_pl($product->id ?? 0)['value'] ?? 0;
        if ($product != null && isset($product->id)) {
            $countOrder = OrderDetail::where('product_id', $product->id ?? 0)->count();
            $countWishlist = Wishlist::where('product_id', $product->id ?? 0)->count();
            $countWishlist_ = Wishlist::where(['product_id' => ($product->id ?? 0) , 'customer_id' => ($storeId)])->count();
            $relatedProducts = Product::with(['reviews'])->active()->whereIn('id', explode(',', $product->linked_products_ids) ?? [])->where('id', '!=', $product->id ?? 0)->limit(12)->get();
            if (!count($relatedProducts)) {
                // $relatedProducts = Product::with(['reviews'])->active()->where('category_ids', $product->category_ids ?? 0)->where('id', '!=', $product->id ?? 0)->limit(12)->get();
            }
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id ?? 0)->where('status', 1)->first();
            $reviews_order = $request['reviews_order'] ?? 'default';
            session()->put('reviews_order', $reviews_order);
            return view('web-views.products.details', compact('product', 'countWishlist', 'countWishlist_', 'countOrder', 'relatedProducts', 'deal_of_the_day', 'reviews_order'));
        }

        Toastr::error(Helpers::translate('not_found'));
        return back();
    }

    public function products(Request $request)
    {
        if(!Helpers::store_module_permission_check('store.products.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $request['order_by'] == null ? $request['order_by'] == 'latest' : $request['order_by'];

        $porduct_data = Product::with(['reviews']);
        $query = $porduct_data;
        if ($request['category_id']) {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    // if ($category['id'] == $request['id']) {
                    if (in_array($request['category_id'], explode(',', $category['id']))) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->orderByRaw('ISNULL(priority), priority ASC')->whereIn('id', $product_ids);
        }

        if ($request['brand_id']) {
            $query = $porduct_data->orderByRaw('ISNULL(priority), priority ASC')->where('brand_id', $request['brand_id']);
        }

        if ($request['data_from'] == 'product') {
            $product = Product::find($request['id']);
            $query = $porduct_data->whereIn('id', explode(',', $product->linked_products_ids) ?? [])->where('id', '!=', $product->id ?? 0);
            $relatedProducts = $query->get();
            if (!count($relatedProducts)) {
                $query = $porduct_data->where('category_ids', $product->category_ids ?? 0)->where('id', '!=', $product->id ?? 0);
            }
        }

        if ($request['order_by'] == 'latest') {
            $query = $porduct_data;
        }

        if ($request['order_by'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['order_by'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['order_by'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['order_by'] == 'featured') {
            $query = Product::with(['reviews'])->where('featured', 1);
        }

        if ($request['order_by'] == 'featured_deal') {
            $featured_deal_id = FlashDeal::where(['status' => 1])->where(['deal_type' => 'feature_deal'])->pluck('id')->first();
            $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id', $featured_deal_id)->pluck('product_id')->toArray();
            $query = Product::with(['reviews'])->whereIn('id', $featured_deal_product_ids);
        }

        if ($request['name']) {
            $key = explode(' ', $request['name']);
            $product_ids = Product::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhereHas('tags',function($query)use($value){
                            $query->where('tag', 'like', "%{$value}%");
                        });
                }
            })->pluck('id');

            if($product_ids->count()==0)
            {
                $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                    ->where('key', 'name')
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('value', 'like', "%{$value}%");
                        }
                    })
                    ->pluck('translationable_id');


            }

            $query = $porduct_data->WhereIn('id', $product_ids);
        }

        if ($request['order_by'] == 'discounted') {
            $query = Product::with(['reviews'])->where('discount', '!=', 0);
        }

        $linkedArr = [];
        $pending_products = [];
        $user_id = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($user_id);
        $pricingLevel = $user->storeInformations['pricing_level'] ?? 1;

        $li = Helpers::get_customer_linked_products_ids()[1];
        $deleted_arr = Helpers::get_customer_linked_products_ids()[2];
        foreach($user->pending_products ?? [] as $product){
            $pending_products[] = $product['local_id'] ?? null;
        }
        if ($request['order_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['order_by'] == 'low-high') {
            $fetched = $query->orderByRaw(DB::raw("CAST(my_unit_price AS FLOAT) ASC"));
        } elseif ($request['order_by'] == 'high-low') {
            $fetched = $query->orderByRaw(DB::raw("CAST(my_unit_price AS FLOAT) DESC"));
        } elseif ($request['order_by'] == 'q-low-high') {
            $fetched = $query->orderBy('current_stock', 'ASC');
        } elseif ($request['order_by'] == 'q-high-low') {
            $fetched = $query->orderBy('current_stock', 'DESC');
        } else{
            $fetched = $query->orderByRaw('ISNULL(priority), priority DESC');
        }
        if ($request['product_type'] == 'linked') {
            $fetched = $query->whereIn('id',$li)->whereNotIn('id',$deleted_arr);
        } elseif ($request['product_type'] == 'not-linked') {
            $fetched = $query->whereNotIn('id',$li)->whereNotIn('id',$deleted_arr);
        } else {
            $fetched = $query->latest();
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'order_by' => $request['order_type'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
        ];


        //$products = $fetched->orderby('priority', 'ASC')->paginate(20)->appends($data);
        $products = $fetched->orderByRaw('ISNULL(priority), priority ASC')->paginate(20)->appends($data);


        if ($request->ajax()) {
            return response()->json([
                'total_product' => $products->total(),
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::find((int)$request['id']);
            if ($brand_data) {
                $data['brand_name'] = $brand_data->name;
            } else {
                Toastr::warning(Helpers::translate('not_found'));
                return redirect('/');
            }
        }
        if ($request['lazy']) {
            return view('web-views.products._ajax-products', compact('products', 'data'), $data);
        }
        return view('web-views.products.view', compact('products', 'data'), $data);
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        if($user->email == "managment@alshammam.com") {
        }else{
            return null;
        }
    }

    public function discounted_products(Request $request)
    {
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with(['reviews']);

        if ($request['data_from'] == 'category') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if ($request['data_from'] == 'latest') {
            $query = $porduct_data->orderBy('id', 'DESC');
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $query = $porduct_data->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        }

        if ($request['data_from'] == 'discounted_products') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            return "low";
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query;
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
        ];

        $products = $fetched->paginate(5)->appends($data);

        if ($request->ajax()) {
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render()
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $data['brand_name'] = Brand::active()->find((int)$request['id'])->name;
        }

        return view('web-views.products.view', compact('products', 'data'), $data);
    }

    public function viewWishlist()
    {
        if(!Helpers::store_module_permission_check('my_account.wish_list.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $digital_product_setting = BusinessSetting::where('type', 'digital_product')->first()->value;

        $wishlists = Wishlist::whereHas('wishlistProduct', function ($q) {
            return $q;
        })->where('customer_id', $storeId)->get();
        return view('web-views.users-profile.account-wishlist', compact('wishlists', 'brand_setting'));
    }

    public function storeWishlist(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        if ($request->ajax()) {
            if ((auth('customer')->check() || auth('delegatestore')->check())) {
                $wishlist = Wishlist::where('customer_id', $storeId)->where('product_id', $request->product_id)->first();
                if (empty($wishlist)) {

                    $wishlist = new Wishlist;
                    $wishlist->customer_id = $storeId;
                    $wishlist->product_id = $request->product_id;
                    $wishlist->save();

                    $countWishlist = Wishlist::whereHas('wishlistProduct', function ($q) {
                        return $q;
                    })->where('customer_id', $storeId)->get();

                    $data = \App\CPU\Helpers::translate("Product has been added to wishlist");

                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
                    session()->put('wish_list', Wishlist::where('customer_id', $user->id)->pluck('product_id')->toArray());
                    return response()->json(['success' => $data, 'value' => 1, 'count' => count($countWishlist), 'id' => $request->product_id, 'product_count' => $product_count]);
                } else {
                    $data = \App\CPU\Helpers::translate("Product already added to wishlist");
                    return response()->json(['error' => $data, 'value' => 2]);
                }
            } else {
                $data = Helpers::translate('login_first');
                return response()->json(['error' => $data, 'value' => 0]);
            }
        }
    }

    public function deleteWishlist(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        Wishlist::where(['product_id' => $request['id'], 'customer_id' => $storeId])->delete();
        $data = \App\CPU\Helpers::translate("Product has been remove from wishlist!");
        $wishlists = Wishlist::where('customer_id', $storeId)->get();
        session()->put('wish_list', Wishlist::where('customer_id', $user->id)->pluck('product_id')->toArray());
        return response()->json([
            'success' => $data,
            'count' => count($wishlists),
            'id' => $request->id,
            'wishlist' => view('web-views.partials._wish-list-data', compact('wishlists'))->render(),
        ]);
    }

    public function notifications()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        // $notifications = Notification::where(function ($q) {
        //     $q->where('sent_to', 'LIKE', '%' . auth('customer')->id() . '%')
        //         ->orWhere('sent_to', null);
        // })
        //     ->where('status', 1)
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        //Edit From Hamza
        $notifications = Notification::where(function ($q) use ($storeId) {
            $q->where('sent_to', $storeId)
              ->orWhere('sent_to', null);
        })
        ->where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('web-views.users-profile.account-notification', compact('notifications'));
    }

    public function notifications_read($id)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $n = Notification::find($id);
        // $seen = $n->seen_by;
        // $seen .= ',' . $storeId;
        // $n->seen_by = $seen;
        // $n->save();
        $n->delete();
        return back();
    }

    public function notifications_get()
    {
        return Helpers::get_customer_notifications();
    }

    //for HelpTopic
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        return view('web-views.help-topics', compact('helps'));
    }

    //for Contact US Page
    public function contacts()
    {
        return view('web-views.contacts');
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        return view('web-views.about-us', [
            'about_us' => $about_us,
        ]);
    }

    public function termsandCondition()
    {
        $terms_condition = BusinessSetting::where('type', 'terms_condition')->first();
        return view('web-views.terms', compact('terms_condition'));
    }

    public function privacy_policy()
    {
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        return view('web-views.privacy-policy', compact('privacy_policy'));
    }

    public function warranty_policy()
    {
        $warranty_policy = BusinessSetting::where('type', 'warranty_policy')->first();
        return view('web-views.warranty_policy', compact('warranty_policy'));
    }

    public function about_us_()
    {
        $warranty_policy = BusinessSetting::where('type', 'about_us')->first();
        return view('web-views.about_us', compact('about_us'));
    }

    //order Details

    public function orderdetails()
    {
        return view('web-views.orderdetails');
    }

    public function chat_for_product(Request $request)
    {
        return $request->all();
    }

    public function supportChat()
    {
        return view('web-views.users-profile.profile.supportTicketChat');
    }

    public function error()
    {
        return view('web-views.404-error-page');
    }

    public function contact_store(Request $request)
    {
        //recaptcha validation
        $recaptcha = Helpers::get_business_settings('recaptcha');
        try {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                        $response = $value;
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                        $response = \file_get_contents($url);
                        $response = json_decode($response);
                        if (!$response->success) {
                            $fail(\App\CPU\Helpers::translate('ReCAPTCHA Failed'));
                        }
                    },
                ],
            ]);
        } catch (\Exception $exception) {
            return back()->withErrors(\App\CPU\Helpers::translate('Captcha Failed'))->withInput($request->input());
        }


        $request->validate([
            'mobile_number' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ], [
            'mobile_number.required' => 'Mobile Number is Empty!',
            'subject.required' => ' Subject is Empty!',
            'message.required' => 'Message is Empty!',

        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile_number = $request->mobile_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        Toastr::success(Helpers::translate('Your Message Send Successfully'));
        return back();
    }

    public function captcha($tmp)
    {

        $phrase = new PhraseBuilder;
        $code = $phrase->build(4);
        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);
        $phrase = $builder->getPhrase();

        if (Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        Session::put('default_captcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function order_note(Request $request)
    {
        if ($request->has('order_note')) {
            session::put('order_note', $request->order_note);
        }
        return response()->json();
    }

    public function digital_product_download($id)
    {
        $order_data = OrderDetail::with('order.customer')->find($id);
        $customer_id = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ($order_data->order->customer->id != $customer_id) {
            Toastr::info(Helpers::translate('Invalid customer'));
            return redirect('/');
        }

        if ($order_data->product->digital_product_type == 'ready_product' && $order_data->product->digital_file_ready) {
            $file_path = storage_path('app/public/product/digital-product/' . $order_data->product->digital_file_ready);
        } else {
            $file_path = storage_path('app/public/product/digital-product/' . $order_data->digital_file_after_sell);
        }

        return \response()->download($file_path);
    }

    public function subscription(Request $request)
    {
        $subscription_email = Subscription::where('email', $request->subscription_email)->first();
        if (isset($subscription_email)) {
            Toastr::info(Helpers::translate('You already subcribed this site!!'));
            return back();
        } else {
            $new_subcription = new Subscription;
            $new_subcription->email = $request->subscription_email;
            $new_subcription->save();

            Toastr::success(Helpers::translate('Your subscription successfully done!!'));
            return back();
        }
    }
    public function review_list_product(Request $request)
    {

        $productReviews = Review::where('product_id', $request->product_id)->latest()->paginate(2, ['*'], 'page', $request->offset);
        $reviews_order = session()->get('reviews_order');
        if ($reviews_order == 'highToLow') {
            $productReviews = Review::where('product_id', $request->product_id)->orderBy('rating', 'desc')->latest()->paginate(2, ['*'], 'page', $request->offset);
        } elseif ($reviews_order == 'lowToHigh') {
            $productReviews = Review::where('product_id', $request->product_id)->orderBy('rating', 'asc')->latest()->paginate(2, ['*'], 'page', $request->offset);
        } elseif ($reviews_order == 'oldToNew') {
            $productReviews = Review::where('product_id', $request->product_id)->orderBy('created_at', 'desc')->latest()->paginate(2, ['*'], 'page', $request->offset);
        } elseif ($reviews_order == 'newToOld') {
            $productReviews = Review::where('product_id', $request->product_id)->orderBy('created_at', 'asc')->latest()->paginate(2, ['*'], 'page', $request->offset);
        }
        $offset = $request->offset;

        return response()->json([
            'productReview' => view('web-views.partials.product-reviews', compact('productReviews', 'offset'))->render(),
            'not_empty' => $productReviews->count()
        ]);
    }

    public function products_sync(Request $request, $skip)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $customer = User::find($storeId);
        try {
            $all = false;
            $col = "pending_products";
            $for_deleted = 0;
            $extensions = ['jpg','png','jpeg'];
            if(isset($request['deleted']) && ($request['deleted'] == "1" || $request['deleted'] == 1)){
                $col = "linked_products";
                $for_deleted = 1;
            }
            session()->put('linked_products_number', 0);
            $salla_access_token = DB::table('oauth_tokens')->where('website', 'salla')->where('user_id', $customer->id)->orderBy('id','desc')->first()->access_token ?? null;
            $categories_ = [];
            ///////////////////////////
            $products_list = [];

            if($for_deleted){
                $deleted_arr = [];
                $user = User::find($storeId);
                foreach ($user->linked_products as $site) {
                    foreach ($site as $product) {
                        if (is_string($product)) {
                            if (!isset(json_decode($product)->deleted) && json_decode($product)->deleted == 1) {
                                $linkedArr[] = json_decode($product)->local_id;
                            } else {
                                $deleted_arr[] = json_decode($product)->local_id;
                            }
                        }else{
                            if (isset($product['deleted']) && $product['deleted'] == 1) {
                                $deleted_arr[] = $product['local_id'];
                            } else {
                                $linkedArr[] = $product['local_id'];
                            }
                        }
                    }
                }
                $products_list = $deleted_arr;
            }else{
                foreach ($customer->$col ?? [] as $product) {
                    if($request->ids == "all" || $request->ids == null || in_array(($product['local_id'] ?? null),explode(',',$request->ids))){
                        $all = true;
                        if($for_deleted){
                            if($product['deleted'] ?? false){
                                $products_list[] = $product['local_id'];
                            }
                        }else{
                            $products_list[] = $product['local_id'];
                        }
                    }
                }
            }
            $items = Product::whereIn('id', $products_list)->whereNotIn('id',explode(',',$request->not_ids))->get();
            $item_index = 0;
            foreach ($items as $p_item_index => $item) {
                if($item->current_stock <= 0){
                    $message = Helpers::translate('product with item number : ').$item->item_number.Helpers::translate('is out_of_stock');
                    return response($message, 500);
                }
                // salla start
                    if ($salla_access_token) {
                        if (isset(json_decode($item->category_ids)[0])) {
                            if (isset(json_decode($item->category_ids)[0]->id)) {
                                $categories = explode(',', json_decode($item->category_ids)[0]->id);
                                foreach ($categories as $index => $category) {
                                    $cat = Category::find($category);
                                    if ($cat) {
                                        $category_name = $cat->name;
                                        if (isset($cat->name)) {
                                            if (count($cat['translations'])) {
                                                foreach ($cat['translations'] as $t) {
                                                    if ($t->locale == "sa" && $t->key == "name") {
                                                        $category_name = $t->value;
                                                    }
                                                }
                                            }
                                            $category_data = SallaHelpers::getCategory($salla_access_token,$category_name);

                                            $catIndex = 0;
                                            $r = $category_data;
                                            if(!isset($r->data)){
                                                Helpers::refresh_salla_token($storeId);
                                                return response(Helpers::translate('problem while connecting..please try again'), $category_data->status ?? 500);
                                            }
                                            foreach($r->data as $dataIndex => $dataa){
                                                if($dataa->name == $category_name){
                                                    $catIndex = $dataIndex;
                                                }
                                            }
                                            if (isset($r->data)) {
                                                if (isset($r->data->id) || isset($r->data[$catIndex]->id)) {
                                                    $categories_[$index] = $r->data->id ?? $r->data[$catIndex]->id;
                                                } else {
                                                    $name = $item->name;
                                                    $newCategory = SallaHelpers::newCategory($salla_access_token,$category_name);

                                                    $categories_[$index] = $newCategory->data->id;
                                                }
                                            } else {
                                                //return dd($category_name);
                                                $name = $item->name;
                                                $newCategory = SallaHelpers::newCategory($salla_access_token,$category_name);
                                                if (!isset($newCategory->data)) {
                                                    return response($newCategory->error->message ? Helpers::translate ($newCategory->error->message) : $newCategory, $newCategory->status ?? 500);
                                                }
                                                $categories_[$index] = $newCategory->data->id;
                                            }
                                        }
                                    }
                                }
                                $brand =  Helpers::get_prop('App\Model\Brand',$item->brand_id,'name');
                                $r = SallaHelpers::getBrand($salla_access_token,$brand);
                                if (isset($r)) {
                                    if (isset($r->data) && isset($r->data[0])) {
                                        if (isset($r->data[0])) {
                                            if (isset($r->data[0]->id)) {
                                                $brand_id = $r->data[0]->id;
                                            }
                                        }
                                    } else {
                                        $brand = Brand::find($item->brand_id);
                                        $logo = storage_path('app/public/brand/' . $brand->image);
                                        $file_info = pathinfo($logo);
                                        $extension = $file_info['extension'];
                                        if(!file_exists($logo) || !(in_array($extension,$extensions))){
                                            $logo = public_path('assets/front-end/img/image-place-holder.png');
                                        }
                                        $logo = new \CURLFile($logo);
                                        $name = Helpers::get_prop('App\Model\Brand',$item->brand_id,'name');
                                        $brand_request_data = array('name' => "$name", 'logo' => $logo, 'banner' => $logo);
                                        $newBrand = SallaHelpers::newBrand($salla_access_token,$brand_request_data);
                                        if (!isset($newBrand->data)) {
                                            if(isset($newBrand->error->message) && $newBrand->error->message == 'alert.invalid_fields'){
                                                $message = "";
                                                $retryBrand = 0;
                                                foreach($newBrand->error->fields as $field=>$err){
                                                    if(in_array($field,['logo','banner'])){
                                                        $retryBrand = 1;
                                                    }
                                                    $message .= $field." : ". implode(',',$err);
                                                    $message .= "<br/>";
                                                }
                                                if($retryBrand){
                                                    $logo = public_path('assets/front-end/img/image-place-holder.png');
                                                    $brand_request_data = array('name' => "$name", 'logo' => $logo, 'banner' => $logo);
                                                    $newBrand = SallaHelpers::newBrand($salla_access_token,$brand_request_data);
                                                    if (!isset($newBrand->data)) {
                                                        if(isset($newBrand->error->message) && $newBrand->error->message == 'alert.invalid_fields'){
                                                            $message = "";
                                                            $retryBrand = 0;
                                                            foreach($newBrand->error->fields as $field=>$err){
                                                                $message .= $field." : ". implode(',',$err);
                                                                $message .= "<br/>";
                                                            }
                                                            return response($message, $newBrand->status ?? 500);
                                                        }
                                                        return response($newBrand->error->message ? Helpers::translate ($newBrand->error->message) : $newBrand, $newBrand->status ?? 500);
                                                    }
                                                }else{
                                                    return response($message, $newBrand->status ?? 500);
                                                }
                                            }
                                            return response($newBrand->error->message ? Helpers::translate ($newBrand->error->message) : $newBrand, $newBrand->status ?? 500);
                                        }
                                        $brand_id = $newBrand->data->id;
                                    }
                                } else {
                                    $brand = Brand::find($item->brand_id);
                                    $logo = storage_path('app/public/brand/' . $brand->image);
                                    $file_info = pathinfo($logo);
                                    $extension = $file_info['extension'];
                                    if(!file_exists($logo) || !(in_array($extension,$extensions))){
                                        $logo = public_path('assets/front-end/img/image-place-holder.png');
                                    }
                                    $logo = new \CURLFile($logo);
                                    $name = Helpers::get_prop('App\Model\Brand',$item->brand_id,'name');
                                    $brand_ = SallaHelpers::getBrand($salla_access_token,$name);
                                    $brand_id = $brand_->data->id;
                                }
                                $current_lang = session()->get('local');
                                $imagesArr = [];
                                $language = \App\Model\BusinessSetting::where('type', 'pnc_language')->first();
                                $language = $language->value ?? null;
                                $def = false;
                                $sort_ = 2;
                                foreach (json_decode($language) as $lang) {
                                    $images = json_decode($item->images)->$lang ?? [];
                                    foreach (explode(',', $item['images_indexing'][$lang] ?? '[]') as $key => $item_) {
                                        if ($item_ !== "") {
                                            $sort = $sort_;
                                            if ($lang == session()->get('local')) {
                                                if ($key == 0) {
                                                    $def = true;
                                                    $sort = 1;
                                                }
                                            }
                                            if (isset($images[$key])) {
                                                $photo = $images[$key];
                                                if(count($imagesArr) <= 9){
                                                    $imagesArr[] = array(
                                                        "original" => asset("storage/app/public/product/$lang/$photo"),
                                                        "thumbnail" => asset("storage/app/public/product/$lang/$photo"),
                                                        "alt" => "image",
                                                        "default" => $def,
                                                        "sort" => $sort
                                                    );
                                                }
                                            }
                                            $def = false;
                                            $sort_++;
                                        }
                                    }
                                }

                                $price = Helpers::get_linked_price($item['id'], auth('customer')->id() ?? auth('delegatestore')->id()) !== 0 ? Helpers::get_linked_price($item['id'], auth('customer')->id() ?? auth('delegatestore')->id()) : (Helpers::getProductPrice_pl($item['id'], $request->user())['suggested_price'] ?? $item->suggested_price ?? Helpers::getProductPrice_pl($item['id'], $request->user())['value']);
                                if(isset(auth('customer')->user()->store_informations['custom_tax']) && isset(auth('customer')->user()->store_informations['custom_tax_value']) && (auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true"){
                                    $sugg_price = $price ?? $item->suggested_price;
                                    $custom_tax = auth('customer')->user()->store_informations['custom_tax_value'];
                                    $custom_tax = $sugg_price*($custom_tax/100);
                                    $sugg_price = number_format((float)($sugg_price+$custom_tax), 2, '.', '');
                                    $price = $sugg_price;
                                }else{
                                    $price = $price ?? $item->suggested_price;
                                }
                                //tags
                                $tags = [];
                                foreach($item->tags->pluck('tag') as $tag){
                                    $tags[] = SallaHelpers::getProductTagId($salla_access_token,$tag);
                                }
                                $content = array(
                                    "name" => "$item->name",
                                    "price" => $price,
                                    "status" => $item->status ? 'sale' : 'out',
                                    "product_type" => "product",
                                    "quantity" => $item->current_stock,
                                    "description" => Helpers::get_prop('App\Model\Product', $item['id'], 'description'),
                                    "categories" => $categories_,
                                    "sale_price" => Helpers::getProductPrice_pl($item['id'])['discount_price'] ?? '',
                                    "cost_price" => Helpers::getProductPrice_pl($item['id'])['value'] ?? $item->cost_price,
                                    "sale_end" => "$item->end_date",
                                    "require_shipping" => ($item->shipping_cost !== '0') ? true : false,
                                    "maximum_quantity_per_order" => null,
                                    "weight" => is_int($item->weight) ? $item->weight : null,
                                    "weight_type" => 'g',
                                    "sku" => "$item->code",
                                    "mpn" => is_int($item->mpn) ? "$item->mpn" : null,
                                    "gtin" => is_int($item->gtin) ? "$item->gtin" : null,
                                    "hide_quantity" => false,
                                    "enable_upload_image" => true,
                                    "enable_note" => true,
                                    "pinned" => true,
                                    "active_advance" => true,
                                    "subtitle" => Helpers::get_prop('App\Model\Product', $item['id'], 'short_desc'),
                                    "promotion_title" => Helpers::get_prop('App\Model\Product', $item['id'], 'promo_title'),
                                    "metadata_title" => "$item->meta_title",
                                    "metadata_description" => "$item->meta_description",
                                    "brand_id" => $brand_id,
                                    "tags" => $tags,
                                    "images" => $imagesArr,
                                    "options" => []
                                );
                                $new_product = SallaHelpers::newProduct($salla_access_token,$content);

                                if((isset($new_product->data->id)))
                                {
                                    $is_sku = 0;
                                    $item_index++;
                                    session()->put('linked_products_number', $item_index);
                                    if (!isset($new_product->data)) {
                                        if(isset($new_product->error->message) && $new_product->error->message == 'alert.invalid_fields'){
                                            $message = "";
                                            foreach($new_product->error->fields as $field=>$err){
                                                if($field == "sku"){
                                                    // $is_sku = 1;
                                                }
                                                $message .= $field." (".$item->code."): ". implode(',',$err);
                                                $message .= "<br/>";
                                            }
                                            if(!$is_sku){
                                                return response($message, 500);
                                            }
                                        }
                                        if(!$is_sku && isset($new_product->error)){
                                            return response('(id: '.$item->id.')'.($new_product->error->message ? Helpers::translate ($new_product->error->message) : $new_product), $new_product->status ?? 500);
                                        }else{
                                            // same sku product exists on salla
                                            $new_product = SallaHelpers::getProductBySku($salla_access_token,$item->code);

                                            if ($err) {
                                                return response('error!',500);
                                            } else {
                                            }
                                        }
                                    }
                                    $linked_id = $new_product->data->id;
                                    $user = User::find($customer->id);
                                    if(!$for_deleted){
                                        $linked_products = $user->linked_products;
                                        if (!isset($linked_products['salla'])) {
                                            $linked_products['salla'] = [];
                                        }
                                        $linked_products_salla = $linked_products['salla'];
                                        $newProduct = [];
                                        $newProduct['linked_id'] = $linked_id;
                                        $newProduct['local_id'] = $item->id;
                                        $newProduct['price'] = $price;

                                        $newProduct['date_synced'] = Carbon::now()->format('Y/m/d h:i A');
                                        $newProduct['deleted'] = 0;
                                        $linked_products_salla[] = $newProduct;
                                        $linked_products['salla'] = $linked_products_salla;
                                        $user->linked_products = $linked_products;
                                        $pending_products = $user->pending_products;
                                        foreach($user->pending_products as $pi=>$p){
                                            if ($p['local_id'] == $item['id']) {
                                                unset($pending_products[$pi]);
                                            }
                                        }
                                        $user->pending_products = $pending_products;
                                        $user->save();
                                    }
                                }
                            }
                        }
                    }
                // salla end

                // zid start
                    $zid_access_token = DB::table('oauth_tokens')->where('website','zid')->where('user_id',$customer->id)->first();
                    if($zid_access_token){
                        if(isset(json_decode($item->category_ids)[0])){
                            if(isset(json_decode($item->category_ids)[0]->id)){
                                $imagesArr = [];
                                $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
                                $language = $language->value ?? null;
                                $def = false;
                                $sort_ = 2;

                                $price = Helpers::get_linked_price($item['id'],auth('customer')->id() ?? auth('delegatestore')->id()) !== 0 ? Helpers::get_linked_price($item['id'],auth('customer')->id() ?? auth('delegatestore')->id()) : (Helpers::getProductPrice_pl($item['id'],$request->user())['suggested_price'] ?? $item->suggested_price ?? Helpers::getProductPrice_pl($item['id'],$request->user())['value']);
                                $current_lang = "sa";
                                $photo = (isset(json_decode($item['images'])->$current_lang)) ? json_decode($item['images'])->$current_lang[0] ?? '' : '';
                                $curl_photo = new \CURLFile(storage_path("app/public/product/$current_lang/" . $photo));
                                $photo = asset("storage/app/public/product/$current_lang").'/'.$photo;
                                $desc = [];
                                $desc['ar'] = Helpers::get_prop('App\Model\Product',$item->id,'name','sa');
                                $desc['ar'] = str_replace(["\r\n", "\n", "\r", "\t"], ' ',$desc['ar']);
                                $desc['ar'] = str_replace(['"'], '\"',$desc['ar']);

                                $desc['en'] = Helpers::get_prop('App\Model\Product',$item->id,'name','en');
                                $desc['en'] = str_replace(["\r\n", "\n", "\r", "\t"], ' ',$desc['en']);
                                $desc['en'] = str_replace(['"'], '\"',$desc['en']);

                                $body = '{
                                    "product_class": "voucher",
                                    "sku": "'.$item->code.'",
                                    "cost": "'.$price.'",
                                    "quantity": "'.($item->current_stock ?? 0).'",
                                    "keywords": [
                                        "test"
                                    ],
                                    "name": {
                                        "ar": "'.(str_replace(["\r\n", "\n", "\r", "\t"], ' ',Helpers::get_prop('App\Model\Product',$item->id,'name','sa'))).'",
                                        "en": "'.(str_replace(["\r\n", "\n", "\r", "\t"], ' ',Helpers::get_prop('App\Model\Product',$item->id,'name','en'))).'"
                                    },
                                    "description": {
                                        "ar": "'.$desc['ar'].'",
                                        "en": "'.$desc['en'].'"
                                    },
                                    "price": "'.$price.'",
                                    "sale_price": "'.$item->sell_price.'",
                                    "weight": {
                                        "unit": "'.((intval($item->unit) == 0) ? 'g' : $item->unit ?? 'g').'",
                                        "value": '.(((($item->weight) == " ") ? 0 : floatval($item->weight)) ?? 0).'
                                    },
                                    "is_published": true
                                }';


                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://api.zid.sa/v1/products/',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS => $body,
                                    CURLOPT_HTTPHEADER => array(
                                      'X-Manager-Token: '.$zid_access_token->access_token,
                                      'STORE-ID: '.$zid_access_token->store_id,
                                      'Accept: application/json',
                                      'Accept-Language: ar',
                                      'ROLE: Manager',
                                      'Content-Type: application/json',
                                      'Authorization: Bearer '.$zid_access_token->authorization
                                    ),
                                ));
                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                                curl_close($curl);

                                if ($err) {
                                    dd(1,$err);
                                } else {
                                    do {
                                        $item_index++;
                                        session()->put('linked_products_number',$item_index);
                                        if(!isset(json_decode($response)->id)){
                                            dd(0,json_decode($response));
                                        }
                                        $linked_id = json_decode($response)->id;
                                        // add image
                                            $curl = curl_init();
                                            curl_setopt_array($curl, array(
                                            CURLOPT_URL => "https://api.zid.sa/v1/products/$linked_id/images/",
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_ENCODING => '',
                                            CURLOPT_MAXREDIRS => 10,
                                            CURLOPT_TIMEOUT => 0,
                                            CURLOPT_FOLLOWLOCATION => true,
                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            CURLOPT_CUSTOMREQUEST => 'POST',
                                            CURLOPT_POSTFIELDS => [
                                                'image' => $curl_photo
                                            ],
                                            CURLOPT_HTTPHEADER => array(
                                                'X-Manager-Token: '.$zid_access_token->access_token,
                                                'STORE-ID: '.$zid_access_token->store_id,
                                                'Accept: application/json',
                                                'Accept-Language: ar',
                                                'ROLE: Manager',
                                                'Content-Type: multipart/form-data',
                                                'Authorization: Bearer '.$zid_access_token->authorization
                                            ),
                                            ));

                                            $response_ = curl_exec($curl);
                                            $err = curl_error($curl);

                                            curl_close($curl);

                                            if ($err) {
                                                dd(2,$err);
                                            } else {
                                            //   dd(3,$response_);
                                            }
                                        // end add image

                                        // add stock
                                        $location_id = null;
                                            // get locations
                                                $curl = curl_init();
                                                curl_setopt_array($curl, [
                                                CURLOPT_URL => "https://api.zid.sa/v1/locations/",
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_ENCODING => "",
                                                CURLOPT_MAXREDIRS => 10,
                                                CURLOPT_TIMEOUT => 30,
                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                CURLOPT_CUSTOMREQUEST => "GET",
                                                CURLOPT_HTTPHEADER => array(
                                                    'X-Manager-Token: '.$zid_access_token->access_token,
                                                    'STORE-ID: '.$zid_access_token->store_id,
                                                    'Accept: application/json',
                                                    'Accept-Language: ar',
                                                    'ROLE: Manager',
                                                    'Content-Type: application/json',
                                                    'Authorization: Bearer '.$zid_access_token->authorization
                                                  ),
                                                ]);

                                                $response_locations = curl_exec($curl);
                                                $err = curl_error($curl);

                                                curl_close($curl);

                                                if ($err) {
                                                    dd(4,$err);
                                                } else {
                                                    foreach(json_decode($response_locations)->results as $location){
                                                        if(isset($location->name->en) && $location->name->en == "Masfufat warehouse"){
                                                            $location_id = $location->id;
                                                        }
                                                    }
                                                    if(!$location_id){
                                                        // create location if masfufat warehouse not exist
                                                            $curl = curl_init();

                                                            curl_setopt_array($curl, [
                                                            CURLOPT_URL => "https://api.zid.sa/v1/locations/",
                                                            CURLOPT_RETURNTRANSFER => true,
                                                            CURLOPT_ENCODING => "",
                                                            CURLOPT_MAXREDIRS => 10,
                                                            CURLOPT_TIMEOUT => 30,
                                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                            CURLOPT_CUSTOMREQUEST => "POST",
                                                            CURLOPT_POSTFIELDS => json_encode([
                                                                'name' => [
                                                                    'ar' => 'مخزن مصفوفات',
                                                                    'en' => 'Masfufat warehouse'
                                                                ],
                                                                'coordinates' => [
                                                                    'longitude' => 45.0792,
                                                                    'latitude' => 23.8859
                                                                ],
                                                                'full_address' => BusinessSetting::where('type', 'shop_address')->first()->value,
                                                                'city' => 38,
                                                                'is_default' => false,
                                                                'is_private' => true,
                                                                'is_enabled' => true
                                                            ]),
                                                            CURLOPT_HTTPHEADER => array(
                                                                'X-Manager-Token: '.$zid_access_token->access_token,
                                                                'STORE-ID: '.$zid_access_token->store_id,
                                                                'Accept: application/json',
                                                                'Accept-Language: ar',
                                                                'ROLE: Manager',
                                                                'Content-Type: application/json',
                                                                'Authorization: Bearer '.$zid_access_token->authorization
                                                              ),
                                                            ]);

                                                            $response_location = curl_exec($curl);
                                                            $err = curl_error($curl);

                                                            curl_close($curl);

                                                            if ($err) {
                                                                dd(5,$err);
                                                            } else {
                                                                $location_id = json_decode($response_location)->id;
                                                            }
                                                        // end create location if masfufat warehouse not exist
                                                    }
                                                }
                                            // end get locations
                                            $curl = curl_init();
                                            curl_setopt_array($curl, [
                                            CURLOPT_URL => "https://api.zid.sa/v1/products/$linked_id/stocks/",
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_ENCODING => "",
                                            CURLOPT_MAXREDIRS => 10,
                                            CURLOPT_TIMEOUT => 30,
                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            CURLOPT_CUSTOMREQUEST => "POST",
                                            CURLOPT_POSTFIELDS => json_encode([
                                                'location' => $location_id,
                                                'available_quantity' => $item->current_stock,
                                                'is_infinite' => false
                                            ]),
                                            CURLOPT_HTTPHEADER => array(
                                                'X-Manager-Token: '.$zid_access_token->access_token,
                                                'STORE-ID: '.$zid_access_token->store_id,
                                                'Accept: application/json',
                                                'Accept-Language: ar',
                                                'ROLE: Manager',
                                                'Content-Type: application/json',
                                                'Authorization: Bearer '.$zid_access_token->authorization
                                              ),
                                            ]);

                                            $response_stock = curl_exec($curl);
                                            $err = curl_error($curl);

                                            curl_close($curl);

                                            if ($err) {
                                                dd(6,$err);
                                            } else {
                                                // dd(7,$response_stock);
                                            }
                                        // end add stock

                                        $response = "";
                                        $user = User::find($customer->id);
                                        if(!$for_deleted){
                                            $linked_products = $user->linked_products;
                                            if (!isset($linked_products['zid'])) {
                                                $linked_products['zid'] = [];
                                            }
                                            $linked_products_zid = $linked_products['zid'];
                                            $newProduct = [];
                                            $newProduct['linked_id'] = $linked_id;
                                            $newProduct['local_id'] = $item->id;
                                            $price = $price ?? $item->suggested_price;

                                            $newProduct['date_synced'] = Carbon::now()->format('Y/m/d h:i A');
                                            $newProduct['deleted'] = 0;
                                            $linked_products_zid[] = $newProduct;
                                            $linked_products['zid'] = $linked_products_zid;
                                            $user->linked_products = $linked_products;
                                            $pending_products = $user->pending_products;
                                            foreach($user->pending_products as $pi=>$p){
                                                if ($p['local_id'] == $item['id']) {
                                                    unset($pending_products[$pi]);
                                                }
                                            }
                                            $user->pending_products = $pending_products;
                                            $user->save();
                                        }
                                    } while (isset(json_decode($response)->id));
                                }
                            }
                        }
                    }
                // zid end
            }
            $user = User::find($customer->id);
            $linked_products = $customer->linked_products;
            if($for_deleted){
                foreach ($linked_products ?? [] as $sitename=>$site) {
                    foreach ($site as $index=>$product) {
                        if($all){
                            if(in_array($product['local_id'],explode(',',$request['ids']))){
                                $linked_products[$sitename][$index]['deleted'] = 0;
                                $products_list[] = $product;
                            }
                        }else{
                            $linked_products[$sitename][$index]['deleted'] = 0;
                            $products_list[] = $product;
                        }
                    }
                }
                $user->linked_products = $linked_products;
            }else{
                $user->pending_products = $pending_products ?? [];
            }
            $user->save();
            return "done";
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function linkedProducts_check(Request $request)
    {
        $r = ((session()->get('linked_products_number')) / ($request['selectedProducts'])) * 100;
        $r = number_format((float)$r, 0, '.', '');
        return $r;
    }

    public function linkedProducts_remove(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $pending_products = $user->pending_products;
        foreach ($pending_products as $i => $p) {
            if ($p['local_id'] == $request['product_id']) {
                unset($pending_products[$i]);
            }
        }
        $user->pending_products = $pending_products;
        $user->save();
        return true;
    }

    public function products_bulk_delete_linked(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $salla_access_token = DB::table('oauth_tokens')->where('website', 'salla')->where('user_id', auth('customer')->user()->id)->first()->access_token;
        if ($request['ids'] == "all") {
            $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
            $linked_products = $user->linked_products;
            foreach ($linked_products as $site_name => $site) {
                // if (!isset($new_linked_products[$site_name])) {
                    if(!isset($request['deleted'])){
                        foreach ($site as $p_index => $product) {
                            if(!in_array($product['local_id'],explode(',',$request->not_ids))){
                                // if(!isset($product['deleted']) || (isset($product['deleted']) && ($product['deleted'] == 0 || $product['deleted'] == "0"))){
                                    unset($linked_products[$site_name][$p_index]);
                                // }
                            }
                        }
                    }else{
                        foreach ($site as $p_index => $product) {
                            if(!in_array($product['local_id'],explode(',',$request->not_ids))){
                                // if(isset($product['deleted']) && ($product['deleted'] == 1 || $product['deleted'] == "1")){
                                    unset($linked_products[$site_name][$p_index]);
                                // }
                            }
                        }
                    }
                // }
                $new_linked_products = $linked_products;
                if(!isset($request['deleted'])){
                    foreach ($site as $index => $product) {
                        $linked_id = json_encode($product['linked_id']);
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://api.salla.dev/admin/v2/products/" . $linked_id,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "DELETE",
                            CURLOPT_HTTPHEADER => [
                                "Authorization: Bearer $salla_access_token",
                                "Content-Type: application/json"
                            ],
                        ]);

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                        } else {
                        }
                    }
                }
            }
            $user->linked_products = $new_linked_products;
            $user->save();
            return back();
        } else {
            $ids = explode(',', $request['ids']);
        }
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $linked_products = $user->linked_products;
        foreach ($ids as $product_id) {
            $linked_id = 0;
            $new_linked_products = [];
            $i = 0;
            $linked_productss = $linked_products;
            foreach ($linked_productss as $site_name => $site) {
                if (!isset($new_linked_products[$site_name])) {
                    $new_linked_products[$site_name] = [];
                }
                foreach ($site as $index => $product) {
                    if (is_string($product)) {
                        $local_id = json_decode($product)->local_id;
                    } else {
                        $local_id = $product['local_id'];
                    }
                    if ($local_id == $product_id) {
                        $linked_id = $product['linked_id'];
                        if(isset($request['deleted'])){
                            unset($linked_products[$site_name][$index]);
                        }else{
                            if(!isset($product['deleted']) || (isset($product['deleted']) && ($product['deleted'] == 0 || $product['deleted'] == "0"))){
                                $curl = curl_init();
                                curl_setopt_array($curl, [
                                    CURLOPT_URL => "https://api.salla.dev/admin/v2/products/" . $linked_id,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "DELETE",
                                    CURLOPT_HTTPHEADER => [
                                        "Authorization: Bearer $salla_access_token",
                                        "Content-Type: application/json"
                                    ],
                                ]);

                                $response = curl_exec($curl);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {

                                } else {
                                }
                            }
                            unset($linked_products[$site_name][$index]);
                        }
                    }
                }
            }
        }
        $user->linked_products = $linked_products;
        $user->save();
        return back();
    }

    public function products_delete(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $salla_access_token = DB::table('oauth_tokens')->where('website', 'salla')->where('user_id',$user->id)->first()->access_token ?? null;
        $linked_products = $user->linked_products;
        $pending_products = $user->pending_products;
        $linked_id_zid = 0;
        $linked_id = 0;
        $new_linked_products = [];
        $i = 0;
        $theIndex = 0;
        foreach ($linked_products as $site_name => $site) {
            if (!isset($new_linked_products[$site_name])) {
                $new_linked_products[$site_name] = [];
            }
            if($site_name == "salla"){
                foreach ($site as $index => $product) {
                    if (is_string($product)) {
                        $local_id = json_decode($product)->local_id;
                    } else {
                        $local_id = $product['local_id'];
                    }
                    if ($local_id == $request->id) {
                        $theIndex = $index;
                        $linked_id = json_encode($product['linked_id']);
                    } else {
                        $new_linked_products[$site_name][$i] = [];
                        $new_linked_products[$site_name][$i] = $product;
                        $i++;
                    }
                }
            }
            if($site_name == "zid"){
                foreach ($site as $index => $product) {
                    if (is_string($product)) {
                        $local_id = json_decode($product)->local_id;
                    } else {
                        $local_id = $product['local_id'];
                    }
                    if ($local_id == $request->id) {
                        $linked_id_zid = $product['linked_id'];
                    } else {
                        $new_linked_products[$site_name][$i] = [];
                        $new_linked_products[$site_name][$i] = $product;
                        $i++;
                    }
                }
            }
        }

        foreach($pending_products as $key => $id){
            if($id == $request->id){
                unset($pending_products[$key]);
                $user->pending_products = $pending_products;
                $user->save();
                return "done";
            }
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.salla.dev/admin/v2/products/" . $linked_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $salla_access_token",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $zid_access_token = DB::table('oauth_tokens')->where('website','zid')->where('user_id',auth('customer')->id() ?? auth('delegatestore')->id())->first();

        if($zid_access_token){
            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.zid.sa/v1/products/$linked_id_zid/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                    'Access-Token: '.$zid_access_token->access_token,
                    'STORE-ID: '.$zid_access_token->store_id,
                    'Accept: application/json',
                    'Accept-Language: ar',
                    'ROLE: Manager',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$zid_access_token->authorization
                ),
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    // dd($response);
                }
            } catch (\Throwable $th) {
                // dd(0,$th);
            }
        }

        if ($err) {
            // dd(1,$err);
            // echo "cURL Error #:" . $err;
        } else {
            $user->save();
            DB::table('users')->where('id',$storeId)->update(['linked_products'=>$new_linked_products]);
            return "done";
        }
    }

    public function products_bulk_delete(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        $all = false;
        if ($request['ids'] == "all") {
            $all = true;
            // $user = User::find(auth('customer')->user()->id);
            $pp_arr = [];
            foreach($user->pending_products as $ppi => $pp){
                if(in_array($pp['local_id'],explode(',',$request->not_ids))){
                    $pp_arr[] = $pp;
                }
            }
            $user->pending_products = $pp_arr;
            $user->save();
            return back();
        } else {
            $ids = explode(',', $request['ids']);
        }
        foreach ($ids as $product_id) {
            $salla_access_token = DB::table('oauth_tokens')->where('user_id', $user->id)->first()->access_token ?? null;
            $user = User::find($storeId);
            // $user = User::find(auth('customer')->user()->id);
            $linked_products = $user->linked_products;
            $linked_id = 0;
            $new_linked_products = [];
            $i = 0;
            foreach ($linked_products as $site_name => $site) {
                if (!isset($new_linked_products[$site_name])) {
                    $new_linked_products[$site_name] = [];
                }
                foreach ($site as $index => $product) {
                    if (is_string($product)) {
                        $local_id = json_decode($product)->local_id ?? '';
                    } else {
                        $local_id = $product['local_id'];
                    }
                    if ($local_id == $product_id) {
                        $linked_id = json_encode($product['linked_id']);
                    } else {
                        $new_linked_products[$site_name][$i] = [];
                        $new_linked_products[$site_name][$i] = $product;
                        $i++;
                    }
                }
            }
            $pending_products = $user->pending_products;
            $linked_id = 0;
            $new_pending_products = [];
            $i = 0;
            foreach ($pending_products as $i => $p) {
                if ($p['local_id'] == $product_id) {
                    unset($pending_products[$i]);
                }
            }
            $user->pending_products = $pending_products;
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.salla.dev/admin/v2/products/" . $linked_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $salla_access_token",
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $user->linked_products = $new_linked_products;
                $user->save();
            }
        }
        return back();
    }

    public function linkedProducts(Request $request)
    {
        $price_inStore = [];
        $deleted_arr = [];
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        foreach ($user->linked_products as $site) {
            foreach ($site as $product) {
                if (is_string($product)) {
                    if (!isset(json_decode($product)->deleted) && json_decode($product)->deleted == 1) {
                        $linkedArr[] = json_decode($product)->local_id;
                    } else {
                        $deleted_arr[] = json_decode($product)->local_id;
                    }
                } else {
                    if (isset($product['deleted']) && $product['deleted'] == 1) {
                    }else{
                        $linkedArr[] = $product['local_id'];
                    }
                }
            }
        }
        foreach ($user->pending_products ?? [] as $product) {
            if (is_string($product)) {
                $pending_products[] = json_decode($product)->local_id;
            } else {
                $pending_products[] = $product['local_id'];
            }
        }

        $products_linked = Product::whereIn('id', $linkedArr)->whereNotIn('id', $deleted_arr)->limit(10)->get();
        $pro_count = count(Product::whereIn('id', $pending_products)->get());
        $products_deleted = Product::whereIn('id', $deleted_arr)->limit(20)->get();
        // $products = Product::whereIn('id', $pending_products)->limit(10);
        $products = DB::table('products')->whereIn('id',Helpers::get_customer_linked_products_ids()[0])->limit(20)->get();
        $pArr = $user->pending_products;
        return view('web-views.linked-products', compact('products', 'products_linked', 'products_deleted', 'pArr', 'pro_count'));
    }

    public function linkedAccounts(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.linking_store_API.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        return view('web-views.linked-accounts');
    }

    public function linkedAccounts_delete(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        DB::table('oauth_tokens')->where('user_id',$storeId)->where('website',$request['id'])->delete();
        Toastr::success(Helpers::translate('unlinked successfully'));
        return back();
    }

    public function linkedProducts_price_edit(Request $request)
    {
        $col = "pending_products";
        $for_deleted = 0;
        if(isset($request['deleted']) && ($request['deleted'] == "1" || $request['deleted'] == 1)){
            $col = "linked_products";
            $for_deleted = 1;
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        if(isset($request['deleted']) && ($request['deleted'] == "1" || $request['deleted'] == 1)){
            $linked_products = $user->$col;
            foreach ($request['price_edits'] ?? [] as $key => $value) {
                $key = str_replace('pid-', '', $key);
                if (!$value) {
                    continue;
                }
                foreach ($linked_products as $index => $product) {
                    if (is_string($product)) {
                        $local_id = $product['local_id'];
                    } else {
                        $local_id = $product['local_id'];
                    }
                    if ($local_id == $key) {
                        $linked_products[$index]['price'] = $value;
                    }
                }
            }
            $user->$col = $linked_products;
            $user->save();
            return true;
        }
        $pending_products = $user->$col;
        foreach ($request['price_edits'] ?? [] as $key => $value) {
            $key = str_replace('pid-', '', $key);
            if (!$value) {
                continue;
            }
            foreach ($pending_products as $index => $product) {
                if (is_string($product)) {
                    $local_id = $product['local_id'];
                } else {
                    $local_id = $product['local_id'];
                }
                if ($local_id == $key) {
                    $pending_products[$index]['price'] = $value;
                }
            }
        }
        $user->$col = $pending_products;
        $user->save();
        return true;
    }

    function list_skip(Request $request)
    {
        $arr = [];
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        foreach ($user->linked_products ?? [] as $pppp) {
            foreach ($pppp ?? [] as $product) {
                if (is_string($product)) {
                    $arr[] = json_decode($product)->local_id;
                } else {
                    $arr[] = $product['local_id'];
                }
            }
        }

        $cols = ['id', 'id','id','id', 'item_number', 'code', 'name', 'unit_price', 'suggested_price',"own_price","date_synced"];
        $pro = DB::table('products')->whereIn('products.id',Helpers::get_customer_linked_products_ids()[$request->tab]);
        $search = $request['search'];
        $s = "";
        $pro = $pro->leftJoin('translations', function ($qq) {
            $qq->on('translations.translationable_id', '=', 'products.id');
        })->where(function($q)use($request,$cols,$user){
            foreach ($request->columns ?? [] as $key => $search) {
                $ss = $search['search']['search'];
                if ($ss) {
                    $s = $ss;
                    if($cols[$key] == "name"){
                        $q
                        ->where('translations.value', 'LIKE', '%' . $ss . '%')
                        ->where('translations.translationable_type', '=', 'App\Model\Product')
                        ->where('translations.key', '=', 'name')
                        ->where('translations.locale', '=', session('local'))
                        ;
                    }elseif(in_array($cols[$key],["unit_price","suggested_price"])){
                        $q->where(function($qq)use($cols,$key,$ss,$user){
                            $qq
                            ->where('products.'.$cols[$key], 'LIKE', '%' . $ss . '%')
                            ->orWhere(function($qqq)use($ss,$user){
                                $qqq
                                ->where('products.pricing', 'LIKE', '%"pricing_level_id%:%'.$user->store_informations['pricing_level'].'%')
                                ->where('products.pricing', 'LIKE', "%value%:%".$ss."%")
                                ;
                            })
                            ;
                        });
                    }elseif(in_array($cols[$key],["unit_price","suggested_price"])){
                        $q->where(function($qq)use($cols,$key,$ss,$user){
                            $qq
                            ->where('products.'.$cols[$key], 'LIKE', '%' . $ss . '%')
                            ->orWhere(function($qqq)use($ss,$user){
                                $qqq
                                ->where('products.pricing', 'LIKE', '%"pricing_level_id%:%'.$user->store_informations['pricing_level'].'%')
                                ->where('products.pricing', 'LIKE', "%value%:%".$ss."%")
                                ;
                            })
                            ;
                        });
                    }elseif(in_array($cols[$key],["own_price"])){
                        $q->where(function($qq)use($cols,$key,$ss,$user){
                            foreach($user->linked_products as $lp){
                                if(isset($lp['price']) && $lp['price'] == $ss){
                                    $qq->where('id',$lp['local_id']);
                                }
                            }
                        });
                    }elseif(in_array($cols[$key],["date_synced"])){
                        $q->where(function($qq)use($cols,$key,$ss,$user){
                            foreach($user->linked_products as $lp){
                                if(isset($lp['date_synced']) && $lp['date_synced'] == $ss){
                                    $qq->where('id',$lp['local_id']);
                                }
                            }
                        });
                    }else{
                        $q->where('products.'.$cols[$key], 'LIKE', '%' . $ss . '%');
                    }
                }
            }
        });
        $pro = $pro->selectRaw('products.*');

        $pro_count = count($pro->get());
        if($s !== ""){
            $enable_limit = false;
        }else{
            $enable_limit = true;
        }
        if($enable_limit){
            if((count($pro->skip($request->skip)->limit(10)->get()) == null) && (count($pro->skip($request->skip)->limit(20)->get()) == null)){
            }else{
                if(count($pro->skip($request->skip)->limit(20)->get()) >= 20){
                    $pro = $pro->skip($request->skip);
                    $pro = $pro->limit(10);
                    $end = 0;
                }else{
                    $end = 1;
                }
            }
        }else{
            if($request->skip !== '0'){
                return false;
            }
        }

        $pro = $pro->groupBy('products.id');
        $pro = $pro->get();
        $pArr = $user->pending_products;
        $formId = ($request->tab == 0) ? 'bulk-delete' : (($request->tab == 1) ? 'bulk-delete-linked' : 'bulk-delete-deleted');
        if($request->tab == 2){
            $delete_function= 'deleteFromList';
            $extra_data = ['is_deleted' => 1, 'Sync' => 'SyncDeleteFromList'];
            return view('web-views.tr',['pro'=>$pro,'delete_function'=>'deleteFromList','formId'=>$formId,
            'extra_data' => ['is_deleted' => 1, 'Sync' => 'SyncDeleteFromList']]);
        }
        if($request->tab == 0){
            return view('web-views.pending-tr', compact('pro', 'search', 'pro_count','formId'));
        }
        return view('web-views.tr', compact('pro', 'search', 'pro_count','formId'));
    }

    public function linked_products_options(Request $request, $option, $value)
    {
        $u = User::find(auth('customer')->user()->id);
        $store_informations = $u->store_informations;
        $store_informations[$option] = $value;
        $u->store_informations = $store_informations;
        $u->save();
    }

    public function linkedProducts_get(Request $request)
    {
        // if(!Helpers::store_module_permission_check('My_Shop.products.pending.view') || !Helpers::store_module_permission_check('My_Shop.products.sync.view') || !Helpers::store_module_permission_check('My_Shop.products.deleted.view')){
        //     Toastr::error( Helpers::translate('You do not have access'));
        //     return back();
        // }
        $linkedArr = [];
        $pendingArr = [];
        $deleted_arr = [];
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        foreach ($user->linked_products ?? [] as $site) {
            foreach ($site as $product) {
                if (is_string($product)) {
                    if (!isset(json_decode($product)->deleted) && json_decode($product)->deleted == 1) {
                        $linkedArr[] = json_decode($product)->local_id;
                    } else {
                        $deleted_arr[] = json_decode($product)->local_id;
                    }
                } else {
                    if (isset($product['deleted']) && $product['deleted'] == 1) {
                        $deleted_arr[] = $product['local_id'];
                    } else {
                        $linkedArr[] = $product['local_id'];
                    }
                }
            }
        }
        foreach ($user->pending_products ?? [] as $product) {
            if (is_string($product)) {
                $pendingArr[] = json_decode($product)->local_id;
            } else {
                $pendingArr[] = $product['local_id'] ?? null;
            }
        }
        $pending_products = [];
        foreach ($user->pending_products ?? [] as $product) {
            if (is_string($product)) {
                $pending_products[] = json_decode($product)->local_id;
            } else {
                $pending_products[] = $product['local_id'] ?? null;
            }
        }
        $products_linked = Product::whereIn('id', $linkedArr)->whereNotIn('id', $deleted_arr)->limit(10)->get();
        $pro_count = [];
        $pro_count[0] = count(Product::whereIn('id', $pending_products)->get());
        $pro_count[1] = Product::whereIn('id', $linkedArr)->whereNotIn('id', $deleted_arr)->count();
        $pro_count[2] = count($deleted_arr);
        $products_deleted = Product::whereIn('id', $deleted_arr)->limit(20)->get();
        $pArr = implode(',', $pendingArr);
        // $products = Product::whereIn('id', $pendingArr)->whereNotIn('id', $linkedArr)->get();
        $products = DB::table('products')->whereIn('id',Helpers::get_customer_linked_products_ids()[0])->limit(20)->get();
        return view('web-views.linked-products', compact('products', 'products_linked', 'products_deleted', 'pArr', 'pro_count'));
    }

    // public function linkedProducts_add(Request $request)
    // {
    //     if(!Helpers::productChoosen($request['product_id'])){
    //         $product = Product::find($request['product_id']);
    //         if($product->current_stock <= 0){
    //             return "out";
    //         }
    //         if ($product['request_status'] == 1 && $product['is_shipping_cost_updated'] == 1 && $product['deleted'] == 0) {
    //             $user = User::find(auth('customer')->user()->id);
    //             $pending_products = $user->pending_products ?? [];
    //             $pending_products[] = array('local_id' => $request['product_id'], 'price' => 0);
    //             $user->pending_products = $pending_products;
    //             $user->save();
    //             return true;
    //         }
    //         dd($product['request_status'] == 1, $product['is_shipping_cost_updated'] == 1, $product['deleted'] == 0, $product['publish_on_market']);
    //     }
    //     return 1;
    // }

    public function linkedProducts_add(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        // تحويل السلسلة النصية إلى مصفوفة من المعرفات
        $product_ids = explode(',', $request->product_id);

        foreach ($product_ids as $product_id) {
            // تحقق من حالة المنتج
            if(!Helpers::productChoosen($product_id)){
                $product = Product::find($product_id);

                // تحقق من مخزون المنتج
                if ($product && $product->current_stock <= 0) {
                    return "out";
                }

                // تحقق من حالات المنتج الأخرى
                if ($product && $product['request_status'] == 1 && $product['is_shipping_cost_updated'] == 1 && $product['deleted'] == 0) {
                    $user = User::find($storeId);
                    $pending_products = $user->pending_products ?? [];

                    // إضافة المنتج إلى قائمة المنتجات المعلقة
                    $pending_products[] = array('local_id' => $product_id, 'price' => 0);

                    $user->pending_products = $pending_products;
                    $user->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function sync_orders(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $orders_ = external_orders::where('seller_id', $user['id'])->orderBy('id', 'desc');
        $orders_ = $orders_->get()->where('order','!=',null)->pluck('id');
        $orders = external_orders::whereIn('id',$orders_)->orderBy('id','desc')->paginate(15);
        return view('web-views.sync_orders', compact('orders'));
    }

    public function sync_orders_skip(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $orders_ = external_orders::where('seller_id', $user['id'])->orderBy('id', 'desc');
        $orders_ = $orders_->get()->where('order','!=',null)->pluck('id');
        $orders = external_orders::whereIn('id',$orders_)->orderBy('id','desc')->paginate(15);
        return view('web-views.sync_orders-tr', compact('orders'));
    }

    public function orders(Request $request)
    {
        if(!Helpers::store_module_permission_check('order.sync.view') && !Helpers::store_module_permission_check('order.direct.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $orders = external_orders::where('seller_id', $user['id'])->orderBy('id', 'desc');
        $orders = $orders->paginate(15);
        return view('web-views.orders', compact('orders'));
    }

    public function orders_show(Request $request, $id)
    {
        if(!Helpers::store_module_permission_check('order.details.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        $mngrId = session('user_type') == 'delegate' ? $user->manager_id : $user->id;
        // $user = User::find(auth('customer')->user()->id);
        $order = Order::whereHas('external_order',function($q)use($storeId){
            $q->where('seller_id',$storeId);
        })->where('seller_is','customer')->where('id',$id)->first();
        if(!$order){
            abort(404);
        }
        Helpers::get_external_order_details($order);
        $e_order = external_orders::find($order->ext_order_id);
        $order_local_id = $id;
        $d = $e_order->details;
        $products = isset($d['data']) ? $d['data']['items'] : null;
        $products = product::whereIn('id',$e_order->items)->get();

        //for next button
        $orders_ = external_orders::where('seller_id', $user['id']);
        $ordersIds = $orders_->get()->where('order','!=',null)->pluck('id');

        $orders = Order::whereIn('ext_order_id', $ordersIds)->get();

        $currentOrderId = $order->id;

        $previousOrder = Order::where('id', '<', $currentOrderId)
          ->whereIn('ext_order_id', $ordersIds)
          ->orderBy('id', 'desc')
          ->first();

        $nextOrder = Order::where('id', '>', $currentOrderId)
        ->whereIn('ext_order_id', $ordersIds)
        ->orderBy('id', 'asc')
        ->first();
        return view('web-views.order-details', compact('order', 'products', 'd', 'order_local_id','e_order','previousOrder','nextOrder'));
    }

    public function products_lazy(Request $request)
    {
        $keyword = $request->query('search', false);
        $brands = Brand::latest()->get();


        $key = explode(' ', $keyword);
        $products = Product::where('added_by', 'admin')->where('status', 1)
            ->when($request->has('category') && $request['category'] != 0, function ($query) use ($request) {
                $query->whereJsonContains('category_ids', [['id' => (string)$request['category']]]);
            })
            ->when($request->has('brand_id') && $request['brand_id'] != 0, function ($query) use ($request) {
                $query->where('brand_id', $request['brand_id']);
            })
            ->when($keyword, function ($query) use ($key) {
                return $query->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%");
                    }
                });
            })->skip($request->skip)->limit(25)->get();
        return view('admin-views.pos.lazy_data', ['products' => $products]);
    }

    public function ttt(Request $request, $path)
    {
        $img = Image::make($path);
        $name = $img->basename;
        $name = $request['w'] . '-' . $request['h'] . $name;
        if (!file_exists('public/resized/' . $name)) {
            $img->resize($request['w'], $request['h']);
            $img->save('public/resized/' . $name, 60);
        }
        return redirect(asset('public/resized/' . $name));
    }

    public function getImg(Request $request, $path)
    {
        $img = Image::make($path);
        $name = $img->basename;
        $name = $request['w'] . '-' . $request['h'] . $name;
        if (!file_exists('public/resized/' . $name)) {
            $img->resize($request['w'] * 10, $request['h'] * 10);
            $img->save('public/resized/' . $name, 60);
        }
        return redirect(asset('public/resized/' . $name));
    }
    public function linkedProductsRemoveDelete(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $linkedProducts = $user->linked_products;
        foreach ($linkedProducts as $key => $products) {
            // foreach ($products as $i => $p) {
            //     if ($p['deleted'] == 1 && $p['local_id'] == $request['product_id']) {
            //         unset($linkedProducts[$key][$i]);
            //     }
            // }
            foreach ($products as $i => $p) {
                $isDeleted = $p['deleted'] ?? 0; // Use null coalescing operator
                if ($isDeleted == 1 && ($p['local_id'] ?? null) == $request['product_id']) {
                    unset($linkedProducts[$key][$i]);
                }
            }
        }
        //dd($linkedProducts);
        $user->linked_products = $linkedProducts;


        $pending_products = $user->pending_products;
        foreach ($pending_products as $i => $p) {
            if (($p['local_id'] ?? null) == $request['product_id']) {
                unset($pending_products[$i]);
                $user->pending_products = $pending_products;
                $user->save();
                return true;
            }
        }
        $user->pending_products = $pending_products;
        $user->save();
        return true;
    }
    public function product_deleted_sync(Request $request) {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $updatedLinkedProducts = [];
        $linkedProducts = $user->linked_products;
        foreach ($linkedProducts as $key => $products) {
            foreach ($products as $i => $p) {
                if ($p['deleted'] == 1 && $p['local_id'] == $request['product_id']) {
                    $p['deleted'] = 0;
                    $linkedProducts[$key][$i]['deleted'] = 0;
                    $updatedLinkedProducts[$key][$i] = $p['local_id'];
                }else{
                    if(!isset($request['product_id'])){
                        $linkedProducts[$key][$i]['deleted'] = 0;
                        $updatedLinkedProducts[$key][$i] = $p['local_id'];
                    }
                }
            }
        }
        $user->linked_products = $linkedProducts;
        $user->save();
        $salla_access_token = DB::table('oauth_tokens')->where('website', 'salla')->where('user_id', $storeId)->first()->access_token ?? null;
        $for_deleted = 0;
        //$user->linked_products = $updatedLinkedProducts;
        $items = Product::whereIn('id', $updatedLinkedProducts['salla'] ?? [$p['local_id']])->get();
            $item_index = 0;
            foreach ($items as $item) {
                // salla start
                if ($salla_access_token) {
                    if (isset(json_decode($item->category_ids)[0])) {
                        if (isset(json_decode($item->category_ids)[0]->id)) {
                            $categories = explode(',', json_decode($item->category_ids)[0]->id);
                            foreach ($categories as $index => $category) {
                                $cat = Category::find($category);
                                if ($cat) {
                                    $category_name = $cat->name;
                                    if (isset($cat->name)) {
                                        if (count($cat['translations'])) {
                                            foreach ($cat['translations'] as $t) {
                                                if ($t->locale == "sa" && $t->key == "name") {
                                                    $category_name = $t->value;
                                                }
                                            }
                                        }
                                        $curl = curl_init();
                                        curl_setopt_array($curl, [
                                            CURLOPT_URL => "https://api.salla.dev/admin/v2/categories?keyword=" . urlencode($category_name),
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_ENCODING => "",
                                            CURLOPT_MAXREDIRS => 10,
                                            CURLOPT_TIMEOUT => 30,
                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            CURLOPT_CUSTOMREQUEST => "GET",
                                            CURLOPT_HTTPHEADER => [
                                                "Authorization: Bearer $salla_access_token",
                                                "Content-Type: application/json"
                                            ],
                                        ]);

                                        $response = curl_exec($curl);

                                        curl_close($curl);

                                        $r = json_decode($response);
                                        if (isset($r->data)) {
                                            if (isset($r->data->id) || isset($r->data[0]->id)) {
                                                $categories_[$index] = $r->data->id ?? $r->data[0]->id;
                                            } else {
                                                //return dd($category_name);
                                                $name = $item->name;
                                                $curl = curl_init();
                                                curl_setopt_array($curl, array(
                                                    CURLOPT_URL => 'https://api.salla.dev/admin/v2/categories',
                                                    CURLOPT_RETURNTRANSFER => true,
                                                    CURLOPT_ENCODING => '',
                                                    CURLOPT_MAXREDIRS => 10,
                                                    CURLOPT_TIMEOUT => 0,
                                                    CURLOPT_FOLLOWLOCATION => true,
                                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                                    CURLOPT_POSTFIELDS => array('name' => "$category_name"),
                                                    CURLOPT_HTTPHEADER => array(
                                                        "Authorization: Bearer $salla_access_token",
                                                    ),
                                                ));
                                                $response = curl_exec($curl);
                                                curl_close($curl);
                                                $categories_[$index] = json_decode($response)->data->id;
                                            }
                                        } else {
                                            //return dd($category_name);
                                            $name = $item->name;
                                            $curl = curl_init();
                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => 'https://api.salla.dev/admin/v2/categories',
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_ENCODING => '',
                                                CURLOPT_MAXREDIRS => 10,
                                                CURLOPT_TIMEOUT => 0,
                                                CURLOPT_FOLLOWLOCATION => true,
                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                CURLOPT_CUSTOMREQUEST => 'POST',
                                                CURLOPT_POSTFIELDS => array('name' => "$category_name"),
                                                CURLOPT_HTTPHEADER => array(
                                                    "Authorization: Bearer $salla_access_token",
                                                ),
                                            ));
                                            $response = curl_exec($curl);
                                            curl_close($curl);
                                            if (!isset(json_decode($response)->data)) {
                                                return response(json_decode($response)->error->message ? Helpers::translate (json_decode($response)->error->message) : json_decode($response), json_decode($response)->status ?? 500);
                                            }
                                            $categories_[$index] = json_decode($response)->data->id;
                                        }
                                    }
                                }
                            }
                            $name = Helpers::get_prop('App\Model\Brand',$item->brand_id,'name');
                            $curl = curl_init();
                            $keyword = urlencode($name);
                            curl_setopt_array($curl, [
                                CURLOPT_URL => "https://api.salla.dev/admin/v2/brands?keyword=" . urlencode($keyword),
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "GET",
                                CURLOPT_HTTPHEADER => [
                                    "Authorization: Bearer $salla_access_token",
                                    "Content-Type: application/json"
                                ],
                            ]);
                            $response = curl_exec($curl);
                            $brand_id = null;
                            $r = json_decode($response);
                            if (isset($r)) {
                                if (isset($r->data)) {
                                    if (isset($r->data[0])) {
                                        if (isset($r->data[0]->id)) {
                                            $brand_id = $r->data[0]->id;
                                        }
                                    }
                                } else {
                                    $extensions = ['jpg','png','jpeg'];
                                    $brand = Brand::find($item->brand_id);
                                    $logo = storage_path('app/public/brand/' . $brand->image);
                                    $file_info = pathinfo($logo);
                                    $extension = $file_info['extension'];
                                    if(!file_exists($logo) || !(in_array($extension,$extensions))){
                                        $logo = public_path('assets/front-end/img/image-place-holder.png');
                                    }
                                    $logo = new \CURLFile($logo);
                                    $name = Helpers::get_prop('App\Model\Brand',$item->brand_id,'name');
                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://api.salla.dev/admin/v2/brands',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => array('name' => "$name", 'logo' => $logo, 'banner' => $logo),
                                        CURLOPT_HTTPHEADER => array(
                                            "Authorization: Bearer $salla_access_token",
                                        ),
                                    ));
                                    $response = curl_exec($curl);
                                    curl_close($curl);
                                    $brand_id = json_decode($response)->data->id;
                                }
                            }
                            $err = curl_error($curl);
                            $current_lang = session()->get('local');
                            $imagesArr = [];
                            $language = \App\Model\BusinessSetting::where('type', 'pnc_language')->first();
                            $language = $language->value ?? null;
                            $def = false;
                            $sort_ = 2;

                            foreach (json_decode($language) as $lang) {
                                $images = json_decode($item->images)->$lang ?? [];
                                foreach (explode(',', $item['images_indexing'][$lang] ?? '[]') as $key => $item_) {
                                    if ($item_ !== "" && $key <= 9) {
                                        if ($item_ !== "") {
                                            $sort = $sort_;
                                            if ($lang == session()->get('local')) {
                                                if ($key == 0) {
                                                    $def = true;
                                                    $sort = 1;
                                                }
                                            }
                                            if (isset($images[$key])) {
                                                $photo = $images[$key];
                                                $imagesArr[] = array(
                                                    "original" => asset("storage/app/public/product/$lang/$photo"),
                                                    "thumbnail" => asset("storage/app/public/product/$lang/$photo"),
                                                    "alt" => "image",
                                                    "default" => $def,
                                                    "sort" => $sort
                                                );
                                            }
                                            $def = false;
                                            $sort_++;
                                        }
                                    }
                                }
                            }

                            $price = Helpers::get_linked_price($item['id'], $request->user()->id) !== 0 ? Helpers::get_linked_price($item['id'], $request->user()->id) : (Helpers::getProductPrice_pl($item['id'], $request->user())['suggested_price'] ?? $item->suggested_price ?? Helpers::getProductPrice_pl($item['id'], $request->user())['value']);
                            $content = array(
                                "name" => "$item->name",
                                "price" => $price,
                                "status" => $item->status ? 'sale' : 'out',
                                "product_type" => "product",
                                "quantity" => $item->current_stock,
                                "description" => Helpers::get_prop('App\Model\Product', $item['id'], 'description'),
                                "categories" => $categories_,
                                "sale_price" => Helpers::getProductPrice_pl($item['id'])['discount_price'] ?? '',
                                "cost_price" => Helpers::getProductPrice_pl($item['id'])['value'] ?? $item->cost_price,
                                "sale_end" => "$item->end_date",
                                "require_shipping" => ($item->shipping_cost !== '0') ? true : false,
                                "maximum_quantity_per_order" => null,
                                "weight" => is_int($item->weight) ? $item->weight : null,
                                "weight_type" => 'g',
                                "sku" => "$item->code",
                                "mpn" => is_int($item->mpn) ? "$item->mpn" : null,
                                "gtin" => is_int($item->gtin) ? "$item->gtin" : null,
                                "hide_quantity" => false,
                                "enable_upload_image" => true,
                                "enable_note" => true,
                                "pinned" => true,
                                "active_advance" => true,
                                "subtitle" => Helpers::get_prop('App\Model\Product', $item['id'], 'short_desc'),
                                "promotion_title" => Helpers::get_prop('App\Model\Product', $item['id'], 'promo_title'),
                                "metadata_title" => "$item->meta_title",
                                "metadata_description" => "$item->meta_description",
                                "brand_id" => $brand_id,
                                "tags" => [],
                                "images" => $imagesArr,
                                "options" => []
                            );
                            $curl = curl_init();

                            curl_setopt_array($curl, [
                                CURLOPT_URL => "https://api.salla.dev/admin/v2/products",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => json_encode($content),
                                CURLOPT_HTTPHEADER => [
                                    "Authorization: Bearer $salla_access_token",
                                    "Content-Type: application/json"
                                ],
                            ]);

                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            curl_close($curl);

                            do {
                                $item_index++;
                                session()->put('linked_products_number', $item_index);
                                $is_sku = 0;
                                if (!isset(json_decode($response)->data)) {
                                    if(isset(json_decode($response)->error->message) && json_decode($response)->error->message == 'alert.invalid_fields'){
                                        $message = "";
                                        foreach(json_decode($response)->error->fields as $field=>$err){
                                            if($field == "sku"){
                                                $is_sku = 1;
                                            }
                                            $message .= $field." (".$item->code."): ". implode(',',$err);
                                            $message .= "<br/>";
                                        }
                                        if(!$is_sku){
                                            return response($message, 500);
                                        }
                                    }
                                    if(!$is_sku){
                                        return response('(id: '.$item->id.')'.(json_decode($response)->error->message ? Helpers::translate (json_decode($response)->error->message) : json_decode($response)), json_decode($response)->status ?? 500);
                                    }else{
                                        $curl = curl_init();
                                        curl_setopt_array($curl, [
                                        CURLOPT_URL => "https://api.salla.dev/admin/v2/products/".$item->code,
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "GET",
                                        CURLOPT_HTTPHEADER => [
                                            "Accept: application/json",
                                            "Authorization: Bearer $salla_access_token"
                                        ],
                                        ]);

                                        $response = curl_exec($curl);
                                        $err = curl_error($curl);

                                        curl_close($curl);

                                        if ($err) {
                                            return response('error!',500);
                                        } else {
                                        }
                                    }
                                }
                                $linked_id = json_decode($response)->data->id;
                                $response = "";
                                $user = User::find($storeId);
                                if(!$for_deleted){
                                    $linked_products = $user->linked_products;
                                    if (!isset($linked_products['salla'])) {
                                        $linked_products['salla'] = [];
                                    }
                                    $linked_products_salla = $linked_products['salla'];
                                    $newProduct = [];
                                    $newProduct['linked_id'] = $linked_id;
                                    $newProduct['local_id'] = $item->id;
                                    $newProduct['price'] = $item->suggested_price;
                                    $newProduct['deleted'] = 0;
                                    $linked_products_salla[] = $newProduct;
                                    $linked_products['salla'] = $linked_products_salla;
                                    $user->linked_products = $linked_products;
                                    $user->save();
                                }
                            } while (isset(json_decode($response)->data->id));
                        }
                    }
                }
                // salla end

                // // zid start
                // $zid_access_token = DB::table('oauth_tokens')->where('website','zid')->where('user_id',$storeId)->first();
                // if($zid_access_token){
                //     if(isset(json_decode($item->category_ids)[0])){
                //         if(isset(json_decode($item->category_ids)[0]->id)){
                //             $imagesArr = [];
                //             $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
                //             $language = $language->value ?? null;
                //             $def = false;
                //             $sort_ = 2;

                //             $price = Helpers::get_linked_price($item['id'],$request->user()->id) !== 0 ? Helpers::get_linked_price($item['id'],$request->user()->id) : (Helpers::getProductPrice_pl($item['id'],$request->user())['suggested_price'] ?? $item->suggested_price ?? Helpers::getProductPrice_pl($item['id'],$request->user())['value']);



                //             $curl = curl_init();
                //             curl_setopt_array($curl, [
                //             CURLOPT_URL => "https://api.zid.sa/v1/products/",
                //             CURLOPT_RETURNTRANSFER => true,
                //             CURLOPT_ENCODING => "",
                //             CURLOPT_MAXREDIRS => 10,
                //             CURLOPT_TIMEOUT => 30,
                //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //             CURLOPT_CUSTOMREQUEST => "POST",
                //             CURLOPT_POSTFIELDS => json_encode([
                //                 'name' => [
                //                     'ar' => Helpers::get_prop('App\Model\Product',$item->id,'name','sa'),
                //                     'en' => Helpers::get_prop('App\Model\Product',$item->id,'name','en')
                //                 ],

                //                 'weight' => ['unit' => (intval($item->unit) == 0) ? 'g' : $item->unit ?? 'g', 'value' => (($item->weight) == " ") ? 0 : floatval($item->weight)],
                //                 'description' => Helpers::get_prop('App\Model\Product',$item->id,'description'),
                //                 'product_class' => Helpers::get_prop('App\Model\Category',$item->id,'name'),
                //                 'requires_shipping' => ($item->shipping_cost !== '0') ? true : false,
                //                 'is_taxable' => $item->has_tax,
                //                 'price' => $price,
                //                 'sale_price' => $item->sell_price,
                //                 'is_infinite' => $item->current_stock == null,
                //                 'quantity' => $item->current_stock ?? 0,
                //                 'has_options' => null,
                //                 'has_fields' => null,
                //                 'is_draft' => 0
                //             ]),
                //             CURLOPT_HTTPHEADER => [
                //                 "Accept: application/json; charset=utf-8",
                //                 "Accept-Language: ",
                //                 "Authorization: Bearer ".$zid_access_token->authorization,
                //                 "Content-Type: application/json",
                //                 "Role: ",
                //                 "Store-Id: ".$zid_access_token->store_id,
                //                 "X-Manager-Token: ".$zid_access_token->access_token
                //             ],
                //             ]);

                //             $response = curl_exec($curl);
                //             $err = curl_error($curl);

                //             curl_close($curl);

                //             if ($err) {
                //                 dd($err);
                //             } else {
                //                 $response = curl_exec($curl);
                //                 $err = curl_error($curl);
                //                 curl_close($curl);

                //                 do {
                //                     $item_index++;
                //                     session()->put('linked_products_number',$item_index);
                //                     if(!isset(json_decode($response)->data)){
                //                         return dd(json_decode($response));
                //                     }
                //                     $linked_id = json_decode($response)->data->id;
                //                     $response = "";
                                    // if(!$for_deleted){
                                    //     $user = User::find($storeId);
                                    //     $linked_products = $user->linked_products;
                                    //     if(!isset($linked_products['salla'])){
                                    //         $linked_products['salla'] = [];
                                    //     }
                                    //     $linked_products_salla = $linked_products['salla'];
                                    //     $newProduct = [];
                                    //     $newProduct['linked_id'] = $linked_id;
                                    //     $newProduct['local_id'] = $item->id;
                                    //     $newProduct['price'] = $item->suggested_price;
                                    //     $linked_products_salla[] = $newProduct;
                                    //     $linked_products['salla'] = $linked_products_salla;
                                    //     $user->linked_products = $linked_products;
                                    //     $user->save();
                                    // }
                //                 } while (isset(json_decode($response)->data->id));
                //             }


                //         }
                //     }
                // }
                // // zid end
            }
        $user->save();
        Toastr::success(Helpers::translate('Resync completed successfully!'));
        return true;
    }
    function checkout_with_customer_view(Request $request,$id)
    {
        $cod_not_show = false;
        $mac_device = false;
        if (str_contains($request->headers->get('User-Agent'), 'iPhone')) {
            $ordered_using = "Web";
            $mac_device = true;
        }
        $payment_gateways_list = [];
        if (Helpers::get_user_paymment_methods(null, 'myfatoorah')['subs_status']) {
            $payment_gateways_list = MyFatoorahController::getPMs();
        }
        $order = Order::find($id);
        if($order->ext_order_id == null && $order->payment_status == 'paid'){
            return view('web-views.checkout-complete');
        }
        if(!$order){
            return redirect('/');
        }
        $shippingMethod = Helpers::get_business_settings('shipping_method');
        if($order->seller_is == "customer"){
            $ext = external_orders::find($order->ext_order_id);
            $user = User::find($ext->seller_id);
        }else{
            $user = User::find($order->customer_id);
        }
        if(!$order->shipping_method_id){
            $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id();
            $shipping = ShippingMethod::where(['status' => 1])->where(['creator_type' => 'admin'])->orderBy('cost','asc')->first();
            if($shipping){
                $order = Order::find($id);
                $order->shipping_method_id = $shipping->id;
                $order->shipping_cost = $shipping->cost;
                $order->shipping_tax = $shipping->tax;
                $order->order_amount = $order->order_amount - $order->shipping_cost + $shipping->cost + ($shipping->cost*($shipping->tax/100));
                $order->save();
            }
        }
        return view('web-views.checkout-pyment-order',compact('order','shippingMethod','payment_gateways_list','mac_device','cod_not_show','user'));
    }

    public function checkout_with_customer(Request $request)
    {
        if($request->payment_method !== "delayed"){
            $request->validate([
                'attachment' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            ], [
                'attachment.required' => Helpers::translate('Please attach the receipt image'),
                'attachment.mimes' => Helpers::translate('Attachment format should be image or pdf'),
            ]);
        }

        $address_id = session('address_id') ? session('address_id') : null;
        if ($request->payment_method !== 'cash_on_delivery' && $request->payment_method !== 'bank_transfer' && $request->payment_method !== 'delayed' && $request->payment_method !== 'pay_by_wallet') {
            return back()->with('error', 'Something went wrong!');
        }
        $order = Order::where('id' , $request->id)->first();
        $customer_id = $order->customer_id;
        if($request->payment_method == "bank_transfer"){
            $order->bank_details = json_encode([
                'bank' => $request->bank,
                'attachment' => (isset($request->attachment) && $request->hasfile('attachment')) ? ImageManager::upload('user/', ($request->attachment)->extension(), $request->attachment) : null,
                'holder_name' => $request->holder_name,
            ]);
        }
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'paid';
        $order->save();
        return back()->with('success', 'Payment completed successfully');
    }
    public function checkout_with_customer_wallet(Request $request)
    {
        $order = Order::find($request->id);
        $ot = Helpers::get_order_totals($order);
        if($order->seller_is == "customer"){
            $user = User::find($order->external_order->seller_id);
        }else{
            $user = User::find($order->customer_id);
        }
        if ($ot['total'] > $user->wallet_balance) {
            Toastr::warning(Helpers::translate('inefficient balance in your wallet to pay for this order!!'));
            return back();
        } else {
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'paid';
            $order->save();

            CustomerManager::create_wallet_transaction($user->id, $ot['total'], 'order_place', 'order payment');
        }
        Toastr::success(Helpers::translate('Payment completed successfully'));
        return back();
    }
    public function insert_into_order_shipping(Request $request)
    {
        $order = Order::find($request['order_id']);
        $shipping = ShippingMethod::find($request['id']);
        $order->shipping_method_id = $request['id'];
        $order->shipping_cost = $shipping->cost;
        $order->shipping_tax = $shipping->tax;
        $order->order_amount = $order->order_amount - $order->shipping_cost + $shipping->cost + ($shipping->cost*($shipping->tax/100));
        $order->save();
        // $shipping['cart_group_id'] = $request['cart_group_id'];
        // $shipping['shipping_method_id'] = $request['id'];
        // $shipping['shipping_cost'] = ShippingMethod::find($request['id'])->cost;
        // $shipping['tax'] = ShippingMethod::find($request['id'])->tax;
        // $spping['shipping_cost'] + ($shipping['shipping_cost']*($shipping['tax']/100));
        // $shipping->save();
        return true;
    }


}
