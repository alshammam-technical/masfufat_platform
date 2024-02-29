<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Model\CustomerWallet;
use App\Model\Transaction;
use Illuminate\Support\Facades\DB;

class RewardPointController extends Controller
{
    public function convert()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $wallet = CustomerWallet::where(['customer_id' => $storeId])->first();
        if ($wallet['royality_points'] != 0) {
            CustomerWallet::where(['customer_id' => $storeId])->increment('balance', $wallet['royality_points'] * 10);
            CustomerWallet::where(['customer_id' => $storeId])->decrement('royality_points', $wallet['royality_points']);
            DB::table('customer_wallet_histories')->insert([
                'customer_id'=>$storeId,
                'transaction_amount'=>$wallet['royality_points'] * 10,
                'transaction_type'=>'points_to_balance',
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            //to do

            return 1;
        }

        //to do

        return 0;
    }
}
