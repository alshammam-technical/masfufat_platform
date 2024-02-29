<?php

namespace App\Http\Controllers\Customer\Auth;

use App\areas;
use App\cities;
use App\countries;
use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\SMS_module;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\PhoneOrEmailVerification;
use App\Model\Subscription;
use App\Model\Wishlist;
use App\Package;
use App\pricing_levels;
use App\provinces;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;


class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function register(Request $request)
    {
        session()->put('keep_return_url', url()->previous());
        $plan = $request->plan ?? 1;
        return view('customer-view.auth.register',compact('plan'));
    }

    public function submit(Request $request)
    {
        $myfile = fopen("reqs/reg-email-".$request['email'].".txt", "w") or die("Unable to open file!");
        fwrite($myfile, $request);
        fclose($myfile);

        $customer = new User(($request)->all());
        if($request->email){
            $customer->email = $request->email;
        }
        if($request->password){
            $customer->password = Hash::make($request->password);
        }
        $store_info = $customer->store_informations;
        foreach($request->all() as $key=>$item){
            if($key !== "email" || $key !== "password"){
                $store_info[$key] = $item;
            }
        }
        if($request->file('image')){
            $store_info['image'] = ImageManager::upload('user/', 'png', $request->file('image'));
        }
        if($request->file('commercial_registration_img')){
            $store_info['commercial_registration_img'] = ImageManager::upload('user/', $request->file('commercial_registration_img')->extension(), $request->file('commercial_registration_img'));
        }
        if($request->file('tax_certificate_img')){
            $store_info['tax_certificate_img'] = ImageManager::upload('user/', $request->file('tax_certificate_img')->extension(), $request->file('tax_certificate_img'));
        }
        $plan = Package::where('price','0')->first();
        $store_info['pricing_level'] = pricing_levels::find($plan->pricing_level)->id;
        $governorate = provinces::find($request['governorate']);
        if($governorate){
            $city = cities::find($governorate['parent_id']);
            $area = areas::find($city['parent_id']);
            $country = countries::find($area['parent_id']);
            $store_info['country'] = $country['id'];
            $store_info['area'] = $area['id'];
            $store_info['city'] = $city['id'];
            $store_info['governorate'] = $request->governorate;
        }
        $store_info['site_url'] = $request->site_url;
        $customer->store_informations = $store_info;
        $customer->is_store = "1";
        $customer->is_active = 1;
        $customer->subscription = Package::where('price','0')->first()->id ?? 0;
        $customer->subscription_start = Carbon::now();
        $customer->subscription_end = Carbon::now()->addDays(14);
        if(isset($store_info['image'])){
            $customer->image = $store_info['image'];
        }
        $customer->save();
        Toastr::success(Helpers::translate('account created successfully'));
        //
        $sub = new Subscription();
        $sub->user_id = $customer->id;
        $sub->package_id = $plan->id;
        $period = $plan->period;
        $sub->period = $period;
        $sub->expiry_date = Carbon::now()->addDays($period);
        $sub->status = "active";
        $sub->payment_method = "-";
        $sub->amount = "0";
        $sub->save();
        //
        auth('customer')->loginUsingId($customer->id, false);
        return redirect(route('subscriptions'));
        if($plan->price == 0){
            return view('customer-view.auth.login');
        }
        return view('customer-view.auth.login');
    }

    public static function verify(Request $request)
    {
        Validator::make($request->all(), [
            'token' => 'required',
        ]);

        $email_status = Helpers::get_business_settings('email_verification');
        $phone_status = Helpers::get_business_settings('phone_verification');

        $user = User::find($request->id);
        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $user->email, 'token' => $request['token']])->first();

        if ($email_status == 1 || ($email_status == 0 && $phone_status == 0)) {
            if (isset($verify)) {
                try {
                    $user->is_email_verified = 1;
                    $user->save();
                    $verify->delete();
                } catch (\Exception $exception) {
                    Toastr::info('Try again');
                }

                Toastr::success(Helpers::translate('verification_done_successfully'));

            } else {
                Toastr::error(Helpers::translate('Verification_code_or_OTP mismatched'));
                return redirect()->back();
            }

        } else {
            if (isset($verify)) {
                try {
                    $user->is_phone_verified = 1;
                    $user->save();
                    $verify->delete();
                } catch (\Exception $exception) {
                    Toastr::info('Try again');
                }

                Toastr::success(Helpers::translate('Verification Successfully Done'));
            } else {
                Toastr::error('Verification code/ OTP mismatched');
            }

        }

        return redirect(route('customer.auth.login'));
    }

    public static function check(Request $request)
    {
        $v = [];
        $v['email'] = 'required|email|unique:users';
        $v["company_name"] = 'required';
        $v["password"] = 'required';
        $req_fields = Helpers::get_business_settings('required_fields')['stores'];
        $req_fields_array = explode(',', $req_fields);
        $req_fields_filtered = array_filter($req_fields_array, function ($value) {
            return $value !== 'activity' && $value !== 'manager_id' && $value !== 'pricing_level' && $value !== 'vendor_account_number';
        });
        $req_fields = array_values($req_fields_filtered);
        foreach($req_fields as $field){
            if($field && $field !== "vendor_account_number" ){
                if($field == "phone" || $field == "delegate_phone"){
                    $v["$field"] = 'required|min:10';
                }
                elseif($field == "image"){
                    $v["$field"] = 'required';
                }else{
                    $v["$field"] = 'required';
                }
            }
            elseif($field == "commercial_registration_img"){
                $v["$field"] = 'required';
            }
            elseif($field == "tax_certificate_img"){
                $v["$field"] = 'required';
            }else{
                $v["$field"] = 'required';
            }
        }
        unset($v['pricing_level']);
        unset($v['vendor_account_number']);
        $messages = [
            'phone.min' => 'يرجى تصحيح الرقم.',
        ];
        $validator = Validator::make($request->all(), $v, $messages);
        if ($validator->errors()->count() > 0) {
            $myfile = fopen("reqs/reg_".$request['email']."-".Carbon::now()->format('YmdHms').".txt", "w") or die("Unable to open file!");
            fwrite($myfile, json_encode(['request' => $request , 'errors' => Helpers::error_processor($validator)]));
            fclose($myfile);
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }else{
            return true;
        }
    }

    public static function login_process($user, $email, $password)
    {
        if (auth('customer')->attempt(['email' => $email, 'password' => $password], true)) {
            $wish_list = Wishlist::whereHas('wishlistProduct',function($q){
                return $q;
            })->where('customer_id', $user->id)->pluck('product_id')->toArray();

            session()->put('wish_list', $wish_list);
            $company_name = BusinessSetting::where('type', 'company_name')->first();
            $message = 'Welcome to ' . $company_name->value . '!';
            CartManager::cart_to_db();
        } else {
            $message = 'Credentials are not matched or your account is not active!';
        }

        return $message;
    }

}
