<?php

namespace App\Http\Controllers\Web;

use App\areas;
use App\cities;
use App\countries;
use App\CPU\CartManager;
use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\Model\Notification;
use function App\CPU\translate;
use App\CPU\ImageManager;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Model\DeliveryCountryCode;
use App\Model\DeliveryZipCode;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\ShippingAddress;
use App\Model\SupportTicket;
use App\Model\Wishlist;
use App\Model\RefundRequest;
use App\Traits\CommonTrait;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\CPU\Convert;
use App\Http\Controllers\MyFatoorahController;
use App\Model\Subscription;
use App\Package;
use App\provinces;
use App\SupportTicketAttachment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

use function React\Promise\all;

class UserProfileController extends Controller
{
    use CommonTrait;
    public function user_account(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.data.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        if ($country_restrict_status) {
            $data = $this->get_delivery_country_array();
        } else {
            $data = COUNTRIES;
        }

        if ($zip_restrict_status) {
            $zip_codes = DeliveryZipCode::all();
        } else {
            $zip_codes = 0;
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $shippingAddresses = \App\Model\ShippingAddress::where('customer_id', $storeId)->get();
            $customerDetail = User::where('id', $storeId)->first();
            return view('web-views.users-profile.account-profile', compact('customerDetail','shippingAddresses', 'country_restrict_status', 'zip_restrict_status', 'data', 'zip_codes'));
        } else {
            return redirect()->route('home');
        }
    }

    public function user_update(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        // ], [
        //     'name.required' => 'Name is required',
        // ]);
        if($request->password !== $request->password_confirmation) {
            Toastr::warning('passwords not match!');
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $customer = User::find($storeId);
        $customer->update(($request)->all());
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
        $governorate = provinces::find($request['governorate']) ?? ['parent_id' => null];
        $city = cities::find($governorate['parent_id']) ?? ['parent_id' => null];
        $area = areas::find($city['parent_id']) ?? ['parent_id' => null];
        $country = countries::find($area['parent_id']) ?? null;
        if($country){
            $store_info['country'] = $country['id'];
            $store_info['area'] = $area['id'];
            $store_info['city'] = $city['id'];
            $store_info['governorate'] = $request->governorate;
        }
        $customer->store_informations = $store_info;
        $customer->name = $request['company_name'];
        $customer->save();
        if(isset($request->bool_r)){
            return true;
        }
        Toastr::success(Helpers::translate('changes saved!'));
        return back();
    }

    public function account_delete($id)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if($storeId == $id)
        {
            $user = User::find($id);
            auth()->guard('customer')->logout();

            ImageManager::delete('/profile/' . $user['image']);
            session()->forget('wish_list');

            $user->delete();
            Toastr::info(\App\CPU\Helpers::translate('Your_account_deleted_successfully!!'));
            return redirect()->route('home');
        }else{
            Toastr::warning('access_denied!!');
        }

    }

    public function account_address()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        if ($country_restrict_status) {
            $data = $this->get_delivery_country_array();
        } else {
            $data = COUNTRIES;
        }

        if ($zip_restrict_status) {
            $zip_codes = DeliveryZipCode::all();
        } else {
            $zip_codes = 0;
        }
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $shippingAddresses = \App\Model\ShippingAddress::where('customer_id', $storeId)->get();
            return view('web-views.users-profile.account-address', compact('shippingAddresses', 'country_restrict_status', 'zip_restrict_status', 'data', 'zip_codes'));
        } else {
            return redirect()->route('home');
        }
    }

    public function address_store(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'address' => 'required',
        ]);

        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        $country_exist = self::delivery_country_exist_check($request->country);
        $zipcode_exist = self::delivery_zipcode_exist_check($request->zip);

        if ($country_restrict_status && !$country_exist) {
            Toastr::error(\App\CPU\Helpers::translate('Delivery_unavailable_in_this_country!'));
            return back();
        }

        if ($zip_restrict_status && !$zipcode_exist) {
            Toastr::error(\App\CPU\Helpers::translate('Delivery_unavailable_in_this_zip_code_area!'));
            return back();
        }

        $address = [
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs ?? 0,
            'title' => $request->title,
            'address' => $request->address,
            'city' => $request->area_id ?? "0",
            'zip' => $request->zip,
            'country' => $request->country,
            'area_id' => $request->area_id,
            'phone' => $request->phone,
            'is_billing' =>0,
            'customer_id' =>$storeId,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if($request->addressAs == 'permanent'){
            ShippingAddress::where('address_type', 'permanent')->where('customer_id',$storeId)->where('id','!=',$request->id)->update(['address_type' => 'home']);
        }
        DB::table('shipping_addresses')->insert($address);
        return back();
    }

    public function address_edit(Request $request,$id)
    {
        if(!Helpers::store_module_permission_check('my_account.data.edit_address')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $shippingAddress = ShippingAddress::where('customer_id',$storeId)->find($id);
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        if ($country_restrict_status) {
            $delivery_countries = self::get_delivery_country_array();
        } else {
            $delivery_countries = 0;
        }
        if ($zip_restrict_status) {
            $delivery_zipcodes = DeliveryZipCode::all();
        } else {
            $delivery_zipcodes = 0;
        }
        if(isset($shippingAddress))
        {
            return view('web-views.users-profile.account-address-edit',compact('shippingAddress', 'country_restrict_status', 'zip_restrict_status', 'delivery_countries', 'delivery_zipcodes'));
        }else{
            Toastr::warning(\App\CPU\Helpers::translate('access_denied'));
            return back();
        }
    }

    public function address_update(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'area_id' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'address' => 'required',
        ]);

        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

        $country_exist = self::delivery_country_exist_check($request->country);
        $zipcode_exist = self::delivery_zipcode_exist_check($request->zip);

        if ($country_restrict_status && !$country_exist) {
            Toastr::error(\App\CPU\Helpers::translate('Delivery_unavailable_in_this_country!'));
            return back();
        }

        if ($zip_restrict_status && !$zipcode_exist) {
            Toastr::error(\App\CPU\Helpers::translate('Delivery_unavailable_in_this_zip_code_area!'));
            return back();
        }

        $updateAddress = [
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs ?? 0,
            'title' => $request->title,
            'address' => $request->address,
            'city' => $request->city ?? "0",
            'zip' => $request->zip,
            'country' => $request->country,
            'area_id' => $request->area_id,
            'phone' => $request->phone,
            'customer_id' => $storeId,
            'is_billing' =>0,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            // if($request->addressAs == 'permanent'){
            //     ShippingAddress::where('address_type', 'permanent')->where('customer_id',$storeId)->where('id','!=',$request->id)->update(['address_type' => 'home']);
            // }
            if ($request->addressAs == 'permanent') {
                ShippingAddress::where('customer_id', $storeId)->update(['address_type' => 0]);
                ShippingAddress::where('id', $request->id)->update(['address_type' => 'permanent']);
            }


            ShippingAddress::where('id', $request->id)->update($updateAddress);
            Toastr::success(\App\CPU\Helpers::translate('Data_updated_successfully!'));
            return redirect()->back();
        } else {
            Toastr::error(\App\CPU\Helpers::translate('Insufficient_permission!'));
            return redirect()->back();
        }
    }

    public function address_delete(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.data.delete_address')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            ShippingAddress::destroy($request->id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_payment()
    {
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            return view('web-views.users-profile.account-payment');

        } else {
            return redirect()->route('home');
        }

    }

    public function account_oder()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $orders = Order::where('customer_id', $storeId)->orderBy('id','DESC')->paginate(15);
        return view('web-views.users-profile.account-orders', compact('orders'));
    }

    public function account_order_details(Request $request)
    {
        if(!Helpers::store_module_permission_check('order.details.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = User::find(auth('customer')->user()->id);
        $order = Order::with(['details.product', 'delivery_man_review'])->find($request->id);
        $previousOrder = Order::where([
            ['id', '<', $order->id],
            ['order_status', '=', $order->order_status],
            ['customer_id', '=', $user->id]
        ])
        ->latest('id')
        ->first();
        $nextOrder = Order::where([
            ['id', '>', $order->id],
            ['order_status', '=', $order->order_status],
            ['customer_id', '=', $user->id]
        ])
        ->orderBy('id', 'asc')
        ->first();
        return view('web-views.users-profile.account-order-details', compact('order','nextOrder','previousOrder'));
    }

    public function account_wishlist()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $wishlists = Wishlist::where('customer_id', $storeId)->get();
            return view('web-views.products.wishlist', compact('wishlists'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_tickets()
    {
        if(!Helpers::store_module_permission_check('my_account.support_ticket.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $supportTickets = SupportTicket::where('customer_id', $storeId)->get();
            return view('web-views.users-profile.account-tickets', compact('supportTickets'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ticket_submit(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $ticket = [
            'subject' => $request['ticket_subject'],
            'type' => $request['ticket_type'],
            'customer_id' => auth('customer')->check() ? $storeId : null,
            'priority' => $request['ticket_priority'] ?? 'Urgent',
            'description' => $request['ticket_description'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        //DB::table('support_tickets')->insert($ticket);
        $ticket_id = DB::table('support_tickets')->insertGetId($ticket);
        if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            // Store the file and save the name and path in the database
            // $filename = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension(); // Get the file extension
            $filename = ImageManager::upload('tickets/attachments/',$fileType,$file);
            $path = 'public/tickets/attachments/'.$filename;

            // Create a new record for each attachment
            $attachment = new SupportTicketAttachment();
            $attachment->ticket_id = $ticket_id; // Use the ticket ID retrieved from the insert
            $attachment->file_name = $filename;
            $attachment->file_path = $path;
            $attachment->file_type = $fileType; // Store the file type
            $attachment->save();
         }
        }
        return back();
    }

    public function single_ticket(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.support_ticket.show_ticket')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id();
        $ticket = SupportTicket::where('id', $request->id)->where('customer_id',$storeId)->first();
        if(!$ticket){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        return view('web-views.users-profile.ticket-view', compact('ticket'));
    }

    public function comment_submit(Request $request, $id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'open',
            'updated_at' => now(),
        ]);

        $ticket_conv_id = DB::table('support_ticket_convs')->insertGetId([
            'customer_message' => $request->comment,
            'support_ticket_id' => $id,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Validate the file types if needed
                $allowedFileTypes = ['jpg', 'jpeg', 'png', 'pdf', 'xls', 'xlsx', 'docx', 'mp4'];
                $fileType = $file->getClientOriginalExtension();
                if (!in_array($fileType, $allowedFileTypes)) {
                    // Handle invalid file type if necessary
                    continue; // Skip this file if it's not a valid type
                }

                // Store the file and save the name and path in the database
                //$filename = $file->getClientOriginalName();
                $filename = ImageManager::upload('tickets/attachments/',$fileType,$file);
                $path = 'public/tickets/attachments/'.$filename;

                // Create a new record for each attachment
                $attachment = new SupportTicketAttachment();
                $attachment->ticket_conv_id = $ticket_conv_id; // Use the ticket conversation ID
                $attachment->file_name = $filename;
                $attachment->file_path = $path;
                $attachment->file_type = $fileType; // Store the file type
                $attachment->save();
            }
        }
        return back();
    }

    public function support_ticket_close($id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'close',
            'updated_at' => now(),
        ]);
        Notification::where('ticket_id', $id)->delete();
        Toastr::success(Helpers::translate('Ticket closed!'));
        return redirect('/account-tickets');
    }

    public function account_transaction()
    {
        $customer_id = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $customer_type = 'customer';
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $transactionHistory = CustomerManager::user_transactions($customer_id, $customer_type);
            return view('web-views.users-profile.account-transaction', compact('transactionHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function support_ticket_delete(Request $request)
    {

        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $support = SupportTicket::find($request->id);
            Notification::where('ticket_id', $support->id)->delete();
            $support->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }

    }

    public function account_wallet_history($user_id, $user_type = 'customer')
    {

        $customer_id = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ((auth('customer')->check() || auth('delegatestore')->check())) {
            $wallerHistory = CustomerManager::user_wallet_histories($customer_id);
            return view('web-views.users-profile.account-wallet', compact('wallerHistory'));
        } else {
            return redirect()->route('home');
        }

    }

    public function track_order()
    {
        if(\App\CPU\Helpers::get_business_settings('order_tracking_status')){
            return view('web-views.order-tracking-page');
        }
        return back();
    }

    public function track_order_result(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user =  auth('customer')->user();
        if(!isset($user)){
            $user_id = User::where('phone',$request->phone_number)->first()->id;
            $orderDetails = Order::where('id',$request['order_id'])->whereHas('details',function ($query) use($user_id){
                $query->where('customer_id',$user_id);
            })->first();

        }else{
            if($user->phone == $request->phone_number){
                $orderDetails = Order::where('id',$request['order_id'])->whereHas('details',function ($query)use($storeId){
                    $query->where('customer_id',$storeId);
                })->first();
            }
            if($request->from_order_details==1)
            {
                $orderDetails = Order::where('id',$request['order_id'])->whereHas('details',function ($query)use($storeId){
                    $query->where('customer_id',$storeId);
                })->first();
            }

        }


        if (isset($orderDetails)){
            return view('web-views.order-tracking', compact('orderDetails'));
        }

        return redirect()->route('track-order.index')->with('Error', \App\CPU\Helpers::translate('Invalid Order Id or Phone Number'));
    }

    public function track_last_order()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $orderDetails = OrderManager::track_order(Order::where('customer_id', $storeId)->latest()->first()->id);

        if ($orderDetails != null) {
            return view('web-views.order-tracking', compact('orderDetails'));
        } else {
            return redirect()->route('track-order.index')->with('Error', \App\CPU\Helpers::translate('Invalid Order Id or Phone Number'));
        }

    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
            OrderManager::stock_update_on_order_status_change($order, 'canceled');
            Order::where(['id' => $id])->update([
                'order_status' => 'canceled'
            ]);
            Toastr::success(\App\CPU\Helpers::translate('successfully_canceled'));
            return back();
        }
        Toastr::error(\App\CPU\Helpers::translate('status_not_changable_now'));
        return back();
    }
    public function refund_request(Request $request,$id)
    {
        $order_details = OrderDetail::find($id);
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        // $user = auth('customer')->user();

        $wallet_status = Helpers::get_business_settings('wallet_status');
        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
        if($loyalty_point_status == 1)
        {
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($id);

            if($user->loyalty_point < $loyalty_point)
            {
                Toastr::warning(\App\CPU\Helpers::translate('you have not sufficient loyalty point to refund this order!!'));
                return back();
            }
        }

        return view('web-views.users-profile.refund-request',compact('order_details'));
    }
    public function store_refund(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $request->validate([
            'order_details_id' => 'required',
            'amount' => 'required',
            'refund_reason' => 'required'

        ]);
        $order_details = OrderDetail::find($request->order_details_id);
        $user = User::find($storeId);
        // $user = auth('customer')->user();


        $loyalty_point_status = Helpers::get_business_settings('loyalty_point_status');
        if($loyalty_point_status == 1)
        {
            $loyalty_point = CustomerManager::count_loyalty_point_for_amount($request->order_details_id);

            if($user->loyalty_point < $loyalty_point)
            {
                Toastr::warning(\App\CPU\Helpers::translate('you have not sufficient loyalty point to refund this order!!'));
                return back();
            }
        }
        $refund_request = new RefundRequest;
        $refund_request->order_details_id = $request->order_details_id;
        $refund_request->customer_id = $storeId;
        $refund_request->status = 'pending';
        $refund_request->amount = $request->amount;
        $refund_request->product_id = $order_details->product_id;
        $refund_request->order_id = $order_details->order_id;
        $refund_request->refund_reason = $request->refund_reason;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('refund/', 'png', $img);
            }
            $refund_request->images = json_encode($product_images);
        }
        $refund_request->save();

        $order_details->refund_request = 1;
        $order_details->save();

        Toastr::success(\App\CPU\Helpers::translate('refund_requested_successful!!'));
        return redirect()->route('account-order-details',['id'=>$order_details->order_id]);
    }

    public function generate_invoice($id)
    {
        $order = Order::with('seller')->with('shipping')->where('id', $id)->first();
        $data["email"] = $order->customer["email"];
        $data["order"] = $order;

        $mpdf_view = View::make('web-views.invoice')->with('order', $order);
        return $mpdf_view;
        Helpers::gen_mpdf($mpdf_view, 'order_invoice_', $order->id);
    }
    public function refund_details($id)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $order_details = OrderDetail::find($id);

        $refund = RefundRequest::where('customer_id',$storeId)
                                ->where('order_details_id',$order_details->id )->first();
        return view('web-views.users-profile.refund-details',compact('order_details','refund'));
    }

    public function submit_review(Request $request,$id)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;

        // $order_details = OrderDetail::where(['id'=>$id])->whereHas('order', function($q) use ($storeId){
        //     $q->where(['customer_id'=>$storeId,'payment_status'=>'paid']);
        // })->first();
        $order_details = OrderDetail::where(['id' => $id])->whereHas('order', function ($q) use ($storeId) {
            $q->whereHas('external_order', function ($q2) use ($storeId) {
                $q2->whereHas('user', function ($q3) use ($storeId) {
                    $q3->where('id', $storeId);
                });
            })->orWhere(function ($q) use ($storeId) {
                $q->where([
                    'customer_id' => $storeId,
                    'payment_status' => 'paid'
                ]);
            });
        })->first();

        if(!$order_details){
            Toastr::error(\App\CPU\Helpers::translate('Invalid order!'));
            return redirect('/');
        }

        return view('web-views.users-profile.submit-review',compact('order_details'));

    }

    public function subscriptions(Request $request)
    {
        if((!auth('customer')->check() && !auth('delegatestore')->check())){
            return redirect(route('customer.auth.login'));
        }
        return view('web-views.users-profile.subscriptions');
    }

    public function subscriptions_pay(Request $request)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if($request['plan_id'] == "free"){
            $plan_id= "free";
            $amount = 0;
        }else{
            $plan_id= $request['plan_id'];
            $amount = Package::find($plan_id)->price;
        }
        if($plan_id == "free"){
            if(Subscription::where(['amount' => 0,'user_id' => $storeId])->first()){
                Toastr::error(Helpers::translate('It is not possible to subscribe to the required package!'));
                return back();
            }
            $plan_id = Package::where('price',0)->first()->id;
            $sub = new Subscription();
            $sub->user_id = $storeId;
            $sub->package_id = $request['plan_id'];
            $period = Package::find($plan_id)->period;
            $sub->amount = Package::find($plan_id)->price;
            $sub->period = $period;
            $sub->expiry_date = Carbon::now()->addDays($period);
            $sub->payment_method = "-";
            $sub->status = "paid";
            $sub->save();
            $user = User::find($storeId);
            $user->subscription = $request['plan_id'];
            $store_informations = $user->store_informations;
            $store_informations['pricing_level'] = Package::find($plan_id)->pricing_level;
            $user->store_informations = $store_informations;
            $user->is_active = 1;
            $user->save();
            $user = User::find($user->id);
            Toastr::success(Helpers::translate('Plan activated successfully!'));

            if(auth('customer')->loginUsingId($user->id, true) || auth('delegatestore')->loginUsingId($user->id, true)) {
                $customer = User::find($storeId);
                $wish_list = Wishlist::whereHas('wishlistProduct',function($q){
                    return $q;
                })->where('customer_id', $customer->id)->pluck('product_id')->toArray();
                $user->login_code = null;
                $user->save();
                session()->put('wish_list', $wish_list);
                CartManager::cart_to_db();
            }else{
                $user->save();
            }
            Toastr::success(Helpers::translate('Plan activated successfully!'));
            return redirect('/');
        }
        $mac_device = false;
        if(str_contains($request->headers->get('User-Agent'),'iPhone')){
            $ordered_using = "Web";
            $mac_device = true;
        }
        $payment_gateways_list = MyFatoorahController::getPMs();
        return view('web-views.users-profile.subscriptions-pay',compact('payment_gateways_list','mac_device','plan_id','amount'));
    }


    public function get_shipping_areas(Request $request)
    {
        if($request['code'] == "SA"){

            $res = Helpers::getSideUpAreas($request['code']);
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://portal.sa.sideup.co/api/areas',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'GET',
            // ));

            // $response = curl_exec($curl);
            // curl_close($curl);
            $r = "<option disabled></option>";
            foreach($res as $item){
                $r .= "<option value='".$item->id."'>". Helpers::translate($item->name) ."</option>";
            }
            return $r;
        }else{
            return null;
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://portal.sa.sideup.co/api/states/'.$request['code'],
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'GET',
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // $r = "<option disabled></option>";
            // foreach(json_decode($response)->data as $item){
            //     if(Helpers::translate($item->name) == Helpers::get_prop('App\provinces',auth('customer')->user()->store_informations['governorate'],'name')){
            //         $r .= "<option selected value='".$item->id."'>". Helpers::translate($item->name) ."</option>";
            //     }else{
            //         $r .= "<option value='".$item->id."'>". Helpers::translate($item->name) ."</option>";
            //     }
            // }
            // return $r;
        }
    }
    public function change_default_address(Request $request) {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if ($request->addressAs == 'permanent') {
            ShippingAddress::where('customer_id', $storeId)->update(['address_type' => 0]);
            ShippingAddress::where('id', $request->id)->update(['address_type' => 'permanent']);
        }else{
            ShippingAddress::where('customer_id', $storeId)->update(['address_type' => 0]);
        }
        return true;
    }
}
