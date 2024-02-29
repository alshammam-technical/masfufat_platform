<?php

namespace App\Http\Controllers\Web;

use App\CPU\CartManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WalletTransaction;
use App\CPU\Helpers;
use App\Http\Controllers\MyFatoorahController;
use App\Model\AddFundBonusCategories;
use App\Model\Cart;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class UserWalletController extends Controller
{
    public function index(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.my_wallet.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        $wallet_status = Helpers::get_business_settings('wallet_status');
        if ($wallet_status == 1) {
            $total_wallet_balance = $user->wallet_balance;
            $wallet_transactio_list = WalletTransaction::where('user_id', $storeId)
                ->when($request->has('type'), function ($query) use ($request) {
                    $query->when($request->type == 'order_transactions', function ($query) {
                        $query->where('transaction_type', 'order_place');
                    })->when($request->type == 'converted_from_loyalty_point', function ($query) {
                        $query->where('transaction_type', 'loyalty_point');
                    })->when($request->type == 'added_via_payment_method', function ($query) {
                        $query->where(['transaction_type' => 'add_fund', 'reference' => 'add_funds_to_wallet']);
                    })->when($request->type == 'add_fund_by_admin', function ($query) {
                        $query->where(['transaction_type' => 'add_fund_by_admin']);
                    })->when($request->type == 'order_refund', function ($query) {
                        $query->where(['transaction_type' => 'order_refund']);
                    });
                })->latest()->paginate(10);

            $payment_gateways = Helpers::payment_gateways();

            $add_fund_bonus_list = AddFundBonusCategories::where('is_active', 1)
                ->whereDate('start_date_time', '<=', date('Y-m-d'))
                ->whereDate('end_date_time', '>=', date('Y-m-d'))
                ->get();

            if ($request->has('flag') && $request->flag == 'success') {
                Toastr::success(Helpers::translate('add_fund_to_wallet_success'));
                return redirect()->route('wallet');
            } else if ($request->has('flag') && $request->flag == 'fail') {
                Toastr::error(Helpers::translate('add_fund_to_wallet_unsuccessful'));
                return redirect()->route('wallet');
            }

            return view('web-views.users-profile.user-wallet', compact('total_wallet_balance', 'wallet_transactio_list', 'payment_gateways', 'add_fund_bonus_list'));
        } else {
            Toastr::warning(\App\CPU\Helpers::translate('access_denied!'));
            return back();
        }
    }

    function charge(Request $request)
    {
        $plan_id= "wallet";
        $mac_device = false;
        if(str_contains($request->headers->get('User-Agent'),'iPhone')){
            $ordered_using = "Web";
            $mac_device = true;
        }
        $amount = 0;
        $payment_gateways_list = MyFatoorahController::getPMs();
        return view('web-views.users-profile.subscriptions-pay',compact('payment_gateways_list','mac_device','plan_id','amount'));
    }
}
