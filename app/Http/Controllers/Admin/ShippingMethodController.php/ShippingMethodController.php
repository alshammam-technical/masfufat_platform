<?php

namespace App\Http\Controllers\Admin;

use App\CPU\BackEndHelper;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\ShippingCompany;
use App\Model\ShippingMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\CategoryShippingCost;
use Illuminate\Support\Facades\Validator;

class ShippingMethodController extends Controller
{
    public function index_admin()
    {
        $shipping_methods = ShippingMethod::where(['creator_type' => 'admin'])->get();

        return view('admin-views.shipping-method.add-new', compact('shipping_methods'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|max:200',
            'duration' => 'required',
        ],[
            'title.required' => 'name is required!',
            'title.max' => 'name too long',
            'duration.required' => 'duration is required!',
        ]);

        if ($validator->errors()->count() > 0) {
            $errs = Helpers::error_processor($validator);
            foreach($errs as $err){
                Toastr::error($err['message']);
            }
            return back();
        }


        DB::table('shipping_methods')->insert([
            'creator_id'   => auth('admin')->id(),
            'creator_type' => 'admin',
            'title'        => $request['title'],
            'duration'     => $request['duration'],
            'cost'         => BackEndHelper::currency_to_usd($request['cost']),
            'tax'          => $request['tax'],
            'status'       => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        Toastr::success(Helpers::translate('Successfully added.'));
        return back();
    }

    public function status_update(Request $request)
    {
        if($request->status){
            if(!Helpers::module_permission_check('shipping-method.setting.enable')){
                return 0;
            }
        }else{
            if(!Helpers::module_permission_check('shipping-method.setting.disable')){
                return 0;
            }
        }
        if($request['id'] == "shipping_cost_view"){
            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_cost_view'], [
                'value' => $request['status']
            ]);
        }elseif($request['id'] == "show_product_price"){
            DB::table('business_settings')->updateOrInsert(['type' => 'show_product_price'], [
                'value' => $request['status']
            ]);
        }else{
            ShippingMethod::where(['id' => $request['id']])->update([
                'status' => $request['status'],
            ]);
        }
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function edit($id)
    {
        if ($id != 1) {
            $method = ShippingMethod::where(['id' => $id])->first();
            return view('admin-views.shipping-method.edit', compact('method'));
        }
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|max:200',
            'duration' => 'required',
            'cost'     => 'numeric',
        ]);

        DB::table('shipping_methods')->where(['id' => $id])->update([
            'creator_id'   => auth('admin')->id(),
            'creator_type' => 'admin',
            'title'        => $request['title'],
            'duration'     => $request['duration'],
            'cost'         => BackEndHelper::currency_to_usd($request['cost']),
            'tax'          => $request['tax'],
            'status'       => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        Toastr::success(Helpers::translate('Successfully updated.'));
        return redirect()->back();
    }

    public function setting()
    {
        $shipping_methods = ShippingMethod::where(['creator_type' => 'admin'])->get();
        $all_category_ids = Category::where(['position' => 0])->pluck('id')->toArray();
        $category_shipping_cost_ids = CategoryShippingCost::where('seller_id',0)->pluck('category_id')->toArray();

        foreach($all_category_ids as $id)
        {
            if(!in_array($id,$category_shipping_cost_ids))
            {
                $new_category_shipping_cost = new CategoryShippingCost;
                $new_category_shipping_cost->seller_id = 0;
                $new_category_shipping_cost->category_id = $id;
                $new_category_shipping_cost->cost = 0;
                $new_category_shipping_cost->save();
            }
        }
        $all_category_shipping_cost = CategoryShippingCost::where('seller_id',0)->get();
        return view('admin-views.shipping-method.setting',compact('all_category_shipping_cost','shipping_methods'));
    }

    public function shippingCompanies(Request $request)
    {
        if($request->has('access__')){
            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_companies_access'], [
                'value' => $request['shipping_companies_access'] ?? 0,
            ]);
        }

        if($request->has('default_shipping_company')){
            $shipping_companies = $request['shipping_companies'];
            $shipping_companies[] = $request['default_shipping_company'];
            $request['shipping_companies'] = $shipping_companies;
            DB::table('business_settings')->updateOrInsert(['type' => 'default_shipping_company'], [
                'value' => $request['default_shipping_company'],
            ]);
        }

        if($request->has('shipping_companies')){
            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_companies'], [
                'value' => json_encode($request['shipping_companies']),
            ]);
        }

        if($request->has('shipping_company_img')){
            $imgs = Helpers::get_business_settings('shipping_company_img');
            foreach($request['shipping_company_img'] as $key=>$sh_img){
                if($request->hasFile("shipping_company_img.$key")){
                    $imgs[$key] = ImageManager::upload('/landing/img/shipping/',$sh_img->extension(),$sh_img);
                }
            }
            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_company_img'], [
                'value' => json_encode($imgs),
            ]);
        }
        Toastr::success(Helpers::translate('Settings Saved Successfully!'));
        return back();
    }

    public function shippingStore(Request $request)
    {
        DB::table('business_settings')->updateOrInsert(['type' => 'shipping_method'], [
            'value' => $request['shippingMethod']
        ]);
        //Toastr::success(Helpers::translate('Shipping Method Added Successfully!'));
        //return back();
        return 1;
    }
    public function delete(Request $request)
    {

        $shipping = ShippingMethod::find($request->id);

        $shipping->delete();
        return response()->json();
    }
    public function costAdjustment($code) {
        $shipping_company = ShippingCompany::find($code);
        return view('admin-views.shipping-method.cost_adjustment', compact('shipping_company'));
    }
    public function editcostadjustment(Request $request){
        $shipping_company = ShippingCompany::find($request->id);
        $shipping_company->shipping_charges = $request->shipping_charges ;
        $shipping_company->tax = $request->tax ;
        $shipping_company->maximum_weight_limit = $request->maximum_weight_limit ;
        $shipping_company->price_per_kilo_extra = $request->price_per_kilo_extra ;
        $shipping_company->price_shipment_recovery = $request->price_shipment_recovery ;
        $shipping_company->total = $request->total ;
        $shipping_company->save();
        //تعديل الصورة
        if($request->has('shipping_company_img')){
            $imgs = Helpers::get_business_settings('shipping_company_img');

            foreach($request['shipping_company_img'] as $key => $sh_img_file){
                if($request->file("shipping_company_img.$key")){
                    $img_path = ImageManager::upload('/landing/img/shipping/', $sh_img_file->extension(), $sh_img_file);
                    $imgs[$key] = $img_path;
                }
            }

            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_company_img'], [
                'value' => json_encode($imgs),
            ]);
        }

        Toastr::success(Helpers::translate('The shipping cost has been set successfully!'));
        return back();
    }

}
