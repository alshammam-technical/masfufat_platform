<?php

namespace App\Http\Middleware;

use App\CPU\Helpers;
use App\Model\Subscription;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('customer')->check()) {
            $user = User::find(auth('customer')->id());
            $sub = Subscription::where(['user_id'=>$user->id,'package_id'=>$user->subscription])->whereIn('status',['paid','active'])->orderBy('id','desc')->first();
            if($sub){
                $exp = Carbon::parse($sub->expiry_date);
                if(Carbon::today()->gte($exp)){
                    $sub->status = "expired";
                    $sub->save();
                    $user->is_active = 0;
                    $user->save();
                }
                $exp_b = Carbon::parse($sub->expiry_date)->subDays(Helpers::get_business_settings('exp_notify_days'));
                $exp = Carbon::parse($sub->expiry_date);
                if(Carbon::today()->gte($exp_b) && Carbon::today()->lte($exp)){
                    session()->put('exp_notify_days',true);
                }else{
                    session()->forget('exp_notify_days');
                }
            }
            if($user->is_active == 0){
                redirect()->route('subscriptions');
            }
            return $next($request);
        }elseif(Auth::guard('delegatestore')->check()){
            // for hamza
            $user = User::find(session('original_store_id'));
            $sub = Subscription::where(['user_id'=>$user->id,'package_id'=>$user->subscription])->whereIn('status',['paid','active'])->orderBy('id','desc')->first();
            if($sub){
                $exp = Carbon::parse($sub->expiry_date);
                if(Carbon::today()->gte($exp)){
                    $sub->status = "expired";
                    $sub->save();
                    $user->is_active = 0;
                    $user->save();
                }
                $exp_b = Carbon::parse($sub->expiry_date)->subDays(Helpers::get_business_settings('exp_notify_days'));
                $exp = Carbon::parse($sub->expiry_date);
                if(Carbon::today()->gte($exp_b) && Carbon::today()->lte($exp)){
                    session()->put('exp_notify_days',true);
                }else{
                    session()->forget('exp_notify_days');
                }
            }
            if($user->is_active == 0){
                redirect()->route('subscriptions');
            }
            return $next($request);


        }elseif (strpos(url()->current(), '/pay-myfatoorah')){
            return $next($request);
        }elseif (Auth::guard('customer')->check()){
            auth()->guard('customer')->logout();
        }
        Toastr::info(Helpers::translate('login_first_for_next_steps'));
        return redirect()->route('customer.auth.login');
    }
}
