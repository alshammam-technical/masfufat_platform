<?php

namespace App\Http\Controllers\Customer;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\ProductManager;

use App\Model\Cart;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\CartShipping;
use App\Model\Category;
use App\Model\DeliveryCountryCode;
use App\Model\DeliveryZipCode;
use App\Model\Product;
use App\Model\ShippingAddress;
use App\Model\ShippingMethod;
use App\Models\OauthToken;
use App\Traits\CommonTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SystemController extends Controller
{
    use CommonTrait;
    public function set_payment_method($name)
    {
        if ((auth('customer')->check() || auth('delegatestore')->check()) || session()->has('mobile_app_payment_customer_id')) {
            session()->put('payment_method', $name);
            return response()->json([
                'status' => 1
            ]);
        }
        return response()->json([
            'status' => 0
        ]);
    }

    public function set_shipping_method(Request $request)
    {
        if ($request['cart_group_id'] == 'all_cart_group') {
            foreach (CartManager::get_cart_group_ids() as $group_id) {
                $request['cart_group_id'] = $group_id;
                self::insert_into_cart_shipping($request);
            }
        } else {
            self::insert_into_cart_shipping($request);
        }

        return response()->json([
            'status' => 1
        ]);
    }

    public static function insert_into_cart_shipping($request)
    {
        $shipping = CartShipping::where(['cart_group_id' => $request['cart_group_id']])->first();
        if (isset($shipping) == false) {
            $shipping = new CartShipping();
        }
        $shipping['cart_group_id'] = $request['cart_group_id'];
        $shipping['shipping_method_id'] = $request['id'];
        $shipping['shipping_cost'] = ShippingMethod::find($request['id'])->cost;
        $shipping['tax'] = ShippingMethod::find($request['id'])->tax;
        $shipping['total'] = $shipping['shipping_cost'] + ($shipping['shipping_cost']*($shipping['tax']/100));
        $shipping->save();
    }

    public function choose_shipping_address(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');

        $physical_product = $request->physical_product;
        $shipping = [];
        $billing = [];
        parse_str($request->shipping, $shipping);
        parse_str($request->billing, $billing);
        $shipping['city'] = $shipping['city'] ?? 999999;
        if (isset($shipping['save_address']) && $shipping['save_address'] == 'on' && ($shipping['shipping_method_id'] == 0)) {

            if ($shipping['contact_person_name'] == null || $shipping['address'] == null || $shipping['city'] == null || $shipping['zip'] == null || $shipping['country'] == null ) {
                return response()->json([
                    'errors' => Helpers::translate('Fill_all_required_fields_of_shipping_address')
                ], 403);
            }
            elseif ($country_restrict_status && !self::delivery_country_exist_check($shipping['country'])) {
                return response()->json([
                    'errors' => Helpers::translate('Delivery_unavailable_in_this_country.')
                ], 403);
            }
            elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                return response()->json([
                    'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                ], 403);
            }
            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => $storeId,
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'] ?? '0',
                'title' => $shipping['title'],
                'address' => $shipping['address'],
                'city' => $shipping['city'] ?? 0,
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'area_id' => $shipping['area_id'],
                'phone' => $shipping['phone'],
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        }
        else if (isset($shipping['shipping_method_id']) && $shipping['shipping_method_id'] == 0) {

            if ($shipping['contact_person_name'] == null || $shipping['address'] == null || $shipping['city'] == null || $shipping['zip'] == null || $shipping['country'] == null ) {
                return response()->json([
                    'errors' => Helpers::translate('Fill_all_required_fields_of_shipping/billing_address')
                ], 403);
            }
            elseif ($country_restrict_status && !self::delivery_country_exist_check($shipping['country'])) {
                return response()->json([
                    'errors' => Helpers::translate('Delivery_unavailable_in_this_country')
                ], 403);
            }
            elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($shipping['zip'])) {
                return response()->json([
                    'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                ], 403);
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => 0,
                'contact_person_name' => $shipping['contact_person_name'],
                'address_type' => $shipping['address_type'],
                'address' => $shipping['address'],
                'city' => $shipping['city'] ?? 0,
                'zip' => $shipping['zip'],
                'country' => $shipping['country'],
                'phone' => $shipping['phone'],
                'latitude' => $shipping['latitude'],
                'longitude' => $shipping['longitude'],
                'is_billing' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        else {
            if (isset($shipping['shipping_method_id'])) {
                $address = ShippingAddress::find($shipping['shipping_method_id']);
                if (!$address->country || !$address->zip) {
                    return response()->json([
                        'errors' => Helpers::translate('Please_update_country_and_zip_for_this_shipping_address')
                    ], 403);
                }
                elseif ($country_restrict_status && !self::delivery_country_exist_check($address->country)) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_country')
                    ], 403);
                }
                elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($address->zip)) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }
                $address_id = $shipping['shipping_method_id'];
            }else{
                $address_id =  0;
            }
        }

        if ($request->billing_addresss_same_shipping == 'false') {
            if (isset($billing['save_address_billing']) && $billing['save_address_billing'] == 'on') {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null|| $billing['billing_zip'] == null || $billing['billing_country'] == null  ) {
                    return response()->json([
                        'errors' => Helpers::translate('Fill_all_required_fields_of_billing_address')
                    ], 403);
                }
                elseif ($country_restrict_status && !self::delivery_country_exist_check($billing['billing_country'])) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_country')
                    ], 403);
                }
                elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($billing['billing_zip'])) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => $storeId,
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'] ?? 0,
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


            }
            elseif ($billing['billing_method_id'] == 0) {

                if ($billing['billing_contact_person_name'] == null || $billing['billing_address'] == null || $billing['billing_city'] == null || $billing['billing_zip'] == null || $billing['billing_country'] == null  ) {
                    return response()->json([
                        'errors' => Helpers::translate('Fill_all_required_fields_of_billing_address')
                    ], 403);
                }
                elseif ($country_restrict_status && !self::delivery_country_exist_check($billing['billing_country'])) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_country')
                    ], 403);
                }
                elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($billing['billing_zip'])) {
                    return response()->json([
                        'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                    ], 403);
                }

                $billing_address_id = DB::table('shipping_addresses')->insertGetId([
                    'customer_id' => 0,
                    'contact_person_name' => $billing['billing_contact_person_name'],
                    'address_type' => $billing['billing_address_type'],
                    'address' => $billing['billing_address'],
                    'city' => $billing['billing_city'] ?? 0,
                    'zip' => $billing['billing_zip'],
                    'country' => $billing['billing_country'],
                    'phone' => $billing['billing_phone'],
                    'latitude' => $billing['billing_latitude'],
                    'longitude' => $billing['billing_longitude'],
                    'is_billing' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            else {
                $address = ShippingAddress::find($billing['billing_method_id']);
                if ($physical_product == 'yes') {
                    if (!$address->country || !$address->zip) {
                        return response()->json([
                            'errors' => Helpers::translate('Update_country_and_zip_for_this_billing_address')
                        ], 403);
                    }
                    elseif ($country_restrict_status && !self::delivery_country_exist_check($address->country)) {
                        return response()->json([
                            'errors' => Helpers::translate('Delivery_unavailable_in_this_country')
                        ], 403);
                    }
                    elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($address->zip)) {
                        return response()->json([
                            'errors' => Helpers::translate('Delivery_unavailable_in_this_zip_code_area')
                        ], 403);
                    }
                }
                $billing_address_id = $billing['billing_method_id'];
            }
        }
        else {
            $billing_address_id = $shipping['shipping_method_id'];
        }

        session()->put('address_id', $address_id);
        session()->put('billing_address_id', $billing_address_id);



        return response()->json([], 200);
    }

    public function products_sync($skip)
    {
        $salla_access_token = OauthToken::where('user_id',Auth::user()->id)->where('website','salla')->first()->access_token;
        $categories_ = [];
        $x = "{\n  \"name\": \"T-Shirt Blue\",\n  \"price\": 96.33,\n  \"status\": \"out\",\n  \"product_type\": \"product\",\n  \"quantity\": 4,\n  \"description\": \"textophonious\",\n  \"categories\": [\n    1032561074,\n    256950451\n  ],\n  \"min_amount_donating\": 1,\n  \"max_amount_donating\": 5,\n  \"sale_price\": 43,\n  \"cost_price\": 35,\n  \"sale_end\": \"2025-08-13\",\n  \"require_shipping\": false,\n  \"maximum_quantity_per_order\": 0,\n  \"weight\": 12,\n  \"weight_type\": \"kg\",\n  \"sku\": \"23-4324432\",\n  \"mpn\": \"45344432343\",\n  \"gtin\": \"58636897\",\n  \"hide_quantity\": false,\n  \"enable_upload_image\": true,\n  \"enable_note\": true,\n  \"pinned\": true,\n  \"active_advance\": true,\n  \"subtitle\": \"Collection 2020\",\n  \"promotion_title\": \"New\",\n  \"metadata_title\": \"T-Shirt blue - collection 2020\",\n  \"metadata_description\": \"T-Shirt blue - collection 2020\",\n  \"brand_id\": 1097509908,\n  \"tags\": [\n    1366932222,\n    591845887\n  ],\n  \"images\": [\n    {\n      \"original\": \"https://salla-dev.s3.eu-central-1.amazonaws.com/nWzD/2E0Z2t6Q8FG3ca620rwqcTY2CC2j2PAGrqqeDROY.jpg\",\n      \"thumbnail\": \"https://salla-dev.s3.eu-central-1.amazonaws.com/nWzD/2E0Z2t6Q8FG3ca620rwqcTY2CC2j2PAGrqqeDROY.jpg\",\n      \"alt\": \"image\",\n      \"default\": true,\n      \"sort\": 5\n    }\n  ],\n  \"options\": [\n    {\n      \"name\": \"option2\",\n      \"display_type\": \"text\",\n      \"values\": [\n        {\n          \"name\": \"الأزرق\",\n          \"price\": 120,\n          \"quantity\": 10\n        },\n        {\n          \"name\": \"الاحمر\",\n          \"price\": 120,\n          \"quantity\": 10\n        },\n        {\n          \"name\": \"الاصفر\",\n          \"price\": 120,\n          \"quantity\": 10\n        }\n      ]\n    },\n    {\n      \"name\": \"option3\",\n      \"display_type\": \"text\",\n      \"values\": [\n        {\n          \"name\": \"كبير\",\n          \"price\": 120,\n          \"quantity\": 10\n        },\n        {\n          \"name\": \"صغير\",\n          \"price\": 120,\n          \"quantity\": 10\n        },\n        {\n          \"name\": \"متوسط\",\n          \"price\": 120,\n          \"quantity\": 10\n        }\n      ]\n    }\n  ]\n}";
        // return json_decode($x);

        ///////////////////////////
        $items = Product::limit(10)->skip($skip ?? 0)->get();
        foreach($items as $item){
            if(isset(json_decode($item->category_ids)[0])){
                if(isset(json_decode($item->category_ids)[0]->id)){
                    $categories = explode(',',json_decode($item->category_ids)[0]->id);
                    foreach($categories as $index=>$category){
                        $cat = Category::find($category);
                        if($cat){
                            $category_name = $cat->name;
                            if(isset($cat->name)){
                                if (count($cat['translations'])) {
                                    foreach ($cat['translations'] as $t) {
                                        if ($t->locale == "sa" && $t->key == "name") {
                                            $category_name = $t->value;
                                        }
                                    }
                                }
                                $curl = curl_init();
                                curl_setopt_array($curl, [
                                    CURLOPT_URL => "https://api.salla.dev/admin/v2/categories?keyword=".$category_name,
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
                                if(isset($r->data)){
                                    if(isset($r->data[0])){
                                        $categories_[$index] = $r->data[0]->id;
                                    }else{
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
                                        CURLOPT_POSTFIELDS => array('name'=>"$category_name"),
                                        CURLOPT_HTTPHEADER => array(
                                            "Authorization: Bearer $salla_access_token",
                                        ),
                                        ));
                                        $response = curl_exec($curl);
                                        curl_close($curl);
                                        $categories_[$index] = json_decode($response)->data->id;
                                    }
                                }else{
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
                                    CURLOPT_POSTFIELDS => array('name'=>"$category_name"),
                                    CURLOPT_HTTPHEADER => array(
                                        "Authorization: Bearer $salla_access_token",
                                    ),
                                    ));
                                    $response = curl_exec($curl);
                                    curl_close($curl);
                                    $categories_[$index] = json_decode($response)->data->id;
                                }
                            }
                        }
                    }
                    $brand = Brand::find($item->brand_id)->name;
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://api.salla.dev/admin/v2/brands?keyword=".$brand,
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
                    if(isset($r)){
                        if(isset($r->data)){
                            if(isset($r->data[0])){
                                if(isset($r->data[0]->id)){
                                    $brand_id = $r->data[0]->id;
                                }
                            }
                        }else{
                            $brand = Brand::find($item->brand_id);
                            $logo = storage_path('app/public/brand/'.$brand->image);
                            $name = $brand->name;
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
                            CURLOPT_POSTFIELDS => array('name'=>"$name",'logo'=> new CURLFILE($logo),'banner'=> new CURLFILE($logo)),
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
                    $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
                    $language = $language->value ?? null;
                    $first_img = true;
                    $imagesArr[] = array(
                        "original" => ProductManager::product_image_path('thumbnail') . '/' . json_decode($item['thumbnail'])->$current_lang,
                        "thumbnail" => ProductManager::product_image_path('thumbnail') . '/' . json_decode($item['thumbnail'])->$current_lang,
                        "alt" => "image",
                        "default" => 1,
                        "sort" => 1
                    );
                    foreach(json_decode($language) as $lang){
                        $images = json_decode($item->images)->$lang ?? [];
                        foreach(explode(',',$item['images_indexing'][$lang] ?? '[]') as $key=>$item_){
                            if(isset($images[$key])){
                                $photo = $images[$key];
                                $imagesArr[] = array(
                                    "original" => asset("storage/app/public/product/$lang/$photo"),
                                    "thumbnail" => asset("storage/app/public/product/$lang/$photo"),
                                    "alt" => "image",
                                    "default" => $key == 0,
                                    "sort" => 5
                                );
                            }
                            $first_img = false;
                        }
                    }
                    $content = array(
                        "name" => "$item->name",
                        "price" => Helpers::getProductPrice_pl($item->id)['value'],
                        "status" => $item->status ? 'sale' : 'out',
                        "product_type" => "product",
                        "quantity" => $item->quantity,
                        "description" => Helpers::get_prop('App\Model\Product',$item['id'],'description'),
                        "categories" => $categories_,
                        "min_amount_donating" => Helpers::getProductPrice_pl($item->id)['min_qty'] ?? $item->min_qty,
                        "max_amount_donating" => Helpers::getProductPrice_pl($item->id)['max_qty'] ?? $item->max_quantity,
                        "sale_price" => Helpers::getProductPrice_pl($item['id'])['discount_price'] ?? '',
                        "cost_price" => Helpers::getProductPrice_pl($item['id'])['value'] ?? $item->cost_price,
                        "sale_end" => "$item->end_date",
                        "require_shipping" => ($item->shipping_cost !== '0') ? true : false,
                        "maximum_quantity_per_order" => Helpers::getProductPrice_pl($item->id)['max_qty'] ?? $item->max_quantity,
                        "weight" => $item->weight,
                        "weight_type" => ($item->unit == 'pc') ? 'g' : $item->unit,
                        "sku" => "$item->code",
                        "mpn" => "$item->mpn",
                        "gtin" => "$item->gtin",
                        "hide_quantity" => false,
                        "enable_upload_image" => true,
                        "enable_note" => true,
                        "pinned" => true,
                        "active_advance" => true,
                        "subtitle" => Helpers::get_prop('App\Model\Product',$item['id'],'short_desc'),
                        "promotion_title" => Helpers::get_prop('App\Model\Product',$item['id'],'promo_title'),
                        "metadata_title" => "$item->meta_title",
                        "metadata_description" => "$item->meta_description",
                        "brand_id" => $brand_id,
                        "tags" => [],
                        "images" => $imagesArr,
                        "options" => []
                    );
                    // return $content;
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
                }
            }
        }
        return "done";
    }
}
