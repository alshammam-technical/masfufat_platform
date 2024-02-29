<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\CartManager;
use App\CPU\Helpers;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Subscription;
use App\Model\Wishlist;
use App\Model\DelegatedStore;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public $company_name;

    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
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

        if(Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        Session::put('default_captcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function login()
    {
        if((auth('customer')->check() || auth('delegatestore')->check())){
            return redirect(route('home'));
        }
        session()->put('keep_return_url', url()->previous());
        return view('customer-view.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|min:1'
        ]);

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
        } catch (\Exception $exception) {}


        $remember = ($request['remember']) ? true : false;

        $delegateStore = DelegatedStore::where(['email' => $request->user_id , 'status' => 1 ])->first();
        if(!isset($delegateStore)){
        $user = User::where(['phone' => $request->user_id])->orWhere(['email' => $request->user_id])->first();

        if (isset($user) == false) {
            Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
            return back()->withInput();
        }else{
            $sub = Subscription::where(['user_id'=>$user->id,'package_id'=>$user->subscription,'status'=>'paid'])->orderBy('id','desc')->first();
            if($sub && $user->is_active){
                $exp = Carbon::createFromFormat('Y-m-d',$sub->expiry_date);
                if(Carbon::today()->gte($exp)){
                    $user->is_active = 0;
                    $user->save();
                    $sub->status = "expired";
                    $sub->save();
                }
            }
        }

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }
        if ($email_verification && !$user->is_email_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }

        if (isset($user) && auth('customer')->attempt(['email' => $user->email, 'password' => $request->password], $remember)) {
            $wish_list = Wishlist::whereHas('wishlistProduct',function($q){
                return $q;
            })->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray();

            session()->put('wish_list', $wish_list);
            Toastr::info(Helpers::translate('Welcome to ') . Helpers::get_business_settings('company_name') . '!');
            CartManager::cart_to_db();
            if(!$user->is_active){
                auth('customer')->loginUsingId($user->id, false);
                return redirect(route('subscriptions'));
            }
            // Helpers::sendSms($user->f_name,$user->phone,Helpers::get_business_settings('login_message')['message']);
            session(['user_type' => 'store']);
            return redirect(session('keep_return_url'));
        }

        Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
        return back()->withInput();

        }else{
            $user = User::where(['id' => $delegateStore->store_id])->first();

            if (isset($user) == false) {
                Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
                return back()->withInput();
            }else{
                $sub = Subscription::where(['user_id'=>$user->id,'package_id'=>$user->subscription,'status'=>'paid'])->orderBy('id','desc')->first();
                if($sub && $user->is_active){
                    $exp = Carbon::createFromFormat('Y-m-d',$sub->expiry_date);
                    if(Carbon::today()->gte($exp)){
                        $user->is_active = 0;
                        $user->save();
                        $sub->status = "expired";
                        $sub->save();
                    }
                }
            }

            $phone_verification = Helpers::get_business_settings('phone_verification');
            $email_verification = Helpers::get_business_settings('email_verification');
            if ($phone_verification && !$user->is_phone_verified) {
                return redirect(route('customer.auth.check', [$user->id]));
            }
            if ($email_verification && !$user->is_email_verified) {
                dd($delegateStore->id);

                return redirect(route('customer.auth.check', [$user->id]));
            }

            if (isset($user) && auth('delegatestore')->attempt(['email' => $request->user_id, 'password' => $request->password], $remember)) {
                $wish_list = Wishlist::whereHas('wishlistProduct',function($q){
                    return $q;
                })->where('customer_id', $delegateStore->store_id)->pluck('product_id')->toArray();

                session()->put('wish_list', $wish_list);
                Toastr::info(Helpers::translate('Welcome to ') . Helpers::get_business_settings('company_name') . '!');
                CartManager::cart_to_db();
                if(!$user->is_active){
                    auth('delegatestore')->loginUsingId($user->id, false);
                    return redirect(route('subscriptions'));
                }
                // Helpers::sendSms($user->f_name,$user->phone,Helpers::get_business_settings('login_message')['message']);
                session(['user_type' => 'delegate']);
                session(['my_id' => $delegateStore->id]);
                session(['original_store_id' => $delegateStore->store_id]);
                auth('delegatestore')->loginUsingId($delegateStore->id);

                return redirect(session('keep_return_url'));
            }
            Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
            return back()->withInput();
        }
    }

    public function submit_phone(Request $request)
    {
        $phone = $request->phone;
        $phone = str_replace('','',$phone);
        $user = User::where(['phone' => $phone])->first();
        $code = rand(1000, 9999);
        $user->login_code = $code;
        $user->save();
        $msg = Helpers::get_business_settings('login_message')['message'];
        $msg = str_replace('{code}',$code,$msg);
        if (Helpers::get_business_settings('msegat_sms')['status'] == 1) {
            Helpers::sendSms(Helpers::get_business_settings('msegat_sms')['sender_name'],str_replace('+','',$user->phone),$msg);
        }
        //
        if (Helpers::get_business_settings('oursms')['status'] == 1) {
            $oursms = Helpers::get_business_settings('oursms');
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.oursms.com/api-a/msgs?username='.$oursms['username'].'&token='.$oursms['api_key'].'&src='.$oursms['username'].'&dests='.str_replace('+','',$user->phone).'&body='.urlencode($msg).'&priority=0&delay=0&validity=0&maxParts=0&dlr=0&prevDups=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        }
        //
        return redirect(route('customer.auth.code',['phone'=>$user->phone]));
    }

    public function login_code(Request $request)
    {
        return view('customer-view.auth.login_code');
    }

    public function submit_code(Request $request)
    {
        $request->validate([
            'login_code' => 'required',
        ]);

        $remember = ($request['remember']) ? true : false;

        $user = User::where('login_code',$request->login_code)->first();

        if (isset($user) == false) {
            Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
            return back()->withInput();
        }

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }
        if ($email_verification && !$user->is_email_verified) {
            return redirect(route('customer.auth.check', [$user->id]));
        }
        if (isset($user) && $user->is_active && auth('customer')->loginUsingId($user->id, $remember)) {
            $wish_list = Wishlist::whereHas('wishlistProduct',function($q){
                return $q;
            })->where('customer_id', $user->id)->pluck('product_id')->toArray();
            $user->login_code = null;
            $user->save();
            session()->put('wish_list', $wish_list);
            Toastr::info( Helpers::translate('Welcome to ') . Helpers::get_business_settings('company_name') . '!');
            CartManager::cart_to_db();
            return redirect(session('keep_return_url'));
        }
        Toastr::error(Helpers::translate('Credentials do not match or account has been suspended.'));
        return back()->withInput();
    }

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        auth()->guard('delegatestore')->logout();
        session()->forget('user_type');
        session()->forget('my_id');
        session()->forget('original_store_id');
        session()->forget('wish_list');
        Toastr::info(Helpers::translate('Come back soon !'));
        return redirect()->route('home');
    }
}
