<?php

namespace App\Http\Controllers\Web;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\DeliveryMan;
use App\Model\Seller;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ChattingController extends Controller
{
    public function chat_list(Request $request, $type)
    {
        if(!Helpers::store_module_permission_check('my_account.chat_with_seller.view') || !Helpers::store_module_permission_check('my_account.chat_with_delivery_man.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if (Helpers::get_business_settings('chat_with_seller_status') !== 1){
            return abort(404);
        }
        if ($type == 'seller')
        {
            $last_chat = Chatting::with(['shop'])->where('user_id', $storeId)
                ->whereNotNull(['seller_id', 'user_id'])
                ->orderBy('created_at', 'DESC')
                ->first();

            if (isset($last_chat)) {
                $chattings = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                    ->select('chattings.*', 'shops.name', 'shops.image')
                    ->where('chattings.user_id', $storeId)
                    ->where('shop_id', $last_chat->shop_id)
                    ->get();

                $unique_shops = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                    ->select('chattings.*', 'shops.name', 'shops.image')
                    ->where('chattings.user_id', $storeId)
                    ->orderBy('chattings.created_at', 'desc')
                    ->get()
                    ->unique('shop_id');

                return view('web-views.users-profile.profile.chat-with-seller', compact('chattings', 'unique_shops', 'last_chat'));
            }
        }

        elseif ($type == 'delivery-man')
        {
            $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
            $last_chat = Chatting::where('user_id', $storeId)
                ->whereNotNull(['delivery_man_id', 'user_id'])
                ->orderBy('created_at', 'DESC')
                ->first();

            if (isset($last_chat)) {
                $chattings = Chatting::join('delivery_men', 'delivery_men.id', '=', 'chattings.delivery_man_id')
                    ->select('chattings.*', 'delivery_men.f_name','delivery_men.l_name', 'delivery_men.image')
                    ->where('chattings.user_id', $storeId)
                    ->where('delivery_man_id', $last_chat->delivery_man_id)
                    ->get();


                $unique_shops = Chatting::join('delivery_men', 'delivery_men.id', '=', 'chattings.delivery_man_id')
                    ->select('chattings.*', 'delivery_men.f_name','delivery_men.l_name', 'delivery_men.image')
                    ->where('chattings.user_id', $storeId)
                    ->orderBy('chattings.created_at', 'desc')
                    ->get()
                    ->unique('delivery_man_id');


                return view('web-views.users-profile.profile.chat-with-seller', compact('chattings', 'unique_shops', 'last_chat'));
            }
        }

        return view('web-views.users-profile.profile.chat-with-seller');

    }
    public function messages(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ($request->has('shop_id'))
        {
            Chatting::where(['user_id'=>$storeId, 'shop_id'=> $request->shop_id])->update([
                'seen_by_customer' => 1
            ]);

            $shops = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                ->select('chattings.*', 'shops.name', 'shops.image')
                ->where('user_id', $storeId)
                ->where('chattings.shop_id', json_decode($request->shop_id))
                ->orderBy('created_at', 'ASC')
                ->get();
        }
        elseif ($request->has('delivery_man_id'))
        {
            Chatting::where(['user_id'=>$storeId, 'delivery_man_id'=> $request->delivery_man_id])->update([
                'seen_by_customer' => 1
            ]);

            $shops = Chatting::join('delivery_men', 'delivery_men.id', '=', 'chattings.delivery_man_id')
                ->select('chattings.*',  'delivery_men.f_name','delivery_men.l_name', 'delivery_men.image')
                ->where('user_id', $storeId)
                ->where('chattings.delivery_man_id', json_decode($request->delivery_man_id))
                ->orderBy('created_at', 'ASC')
                ->get();
        }
        return response()->json($shops);
    }

    public function messages_store(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.chat_with_seller.send_message')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ($request->message == '') {
            return response()->json(Helpers::translate('type_something!'), 403);
        }

        if ($request->has('shop_id'))
        {
            $message = $request->message;
            Chatting::create([
                'user_id'          => $storeId,
                'shop_id'          => $request->shop_id,
                'seller_id'        => $request->seller_id,
                'message'          => $request->message,
                'sent_by_customer' => 1,
                'seen_by_customer' => 1,
                'seen_by_seller' => 0,
                'created_at'       => now(),
            ]);

            $seller = Seller::find($request->seller_id);
            $fcm_token = $seller->cm_firebase_token;

        }

        elseif ($request->has('delivery_man_id'))
        {
            $message = $request->message;
            Chatting::create([
                'user_id'          => $storeId,
                'delivery_man_id'  => $request->delivery_man_id,
                'message'          => $request->message,
                'sent_by_customer' => 1,
                'seen_by_customer' => 0,
                'created_at'       => now(),
            ]);

            $dm = DeliveryMan::find($request->delivery_man_id);
            $fcm_token = $dm->fcm_token;
        }

        if(!empty($fcm_token)) {
            $data = [
                'title' => Helpers::translate('message'),
                'description' => $request->message,
                'order_id' => '',
                'image' => '',
            ];
            Helpers::send_push_notif_to_device($fcm_token, $data);
        }

        return response()->json($message);
    }

}
