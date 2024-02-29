<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DelegatedStore;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Model\BusinessSetting;
use App\CPU\Helpers;
use App\User;
use Illuminate\Support\Facades\Validator;

class DelegatedStoreController extends Controller
{
    public function list(Request $request){
        if(!Helpers::store_module_permission_check('my_account.employees.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $store = User::find($storeId );
        $delegates = $store->delegates;
        $mng = new DelegatedStore;
        $mng->id ="01";
        $mng->name =$store->name;
        $mng->email =$store->email;
        $mng->phone =$store->phone;
        $mng->status ="1";
        $delegates->prepend($mng);
        return view('web-views.delegate.list',compact('delegates'));
    }

    public function add(Request $request){
        if(!Helpers::store_module_permission_check('my_account.employees.view')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $employees = DelegatedStore::where('store_id',$storeId )->get();
        $delegate = new DelegatedStore;
        $role = $delegate->first(['id', 'name', 'module_access','input_access']);
        $pages = [
            "Home" => [
                "children" => [
                    [
                        "caption" => "Home Page",
                        "name" => "store.home",
                        "actions" => ['view','show_notifications','show_cart','show_education']
                    ],
                ],
            ],
            "products" => [
                "children" => [
                    [
                        "caption" => "Products",
                        "name" => "store.products",
                        "actions" => ['view','add_to_cart','syncc']
                    ],
                    [
                        "caption" => "Products Details",
                        "name" => "store.products_details",
                        "actions" => ['view','add_to_cart','syncc']
                    ],
                ],
            ],
            "My Shop" => [
                "children" => [
                    [
                        "caption" => "My linked products (in pending)",
                        "name" => "My_Shop.products.pending",
                        "actions" => ['view','save','delete','save_and_sync','settings_of_synchronization']
                    ],
                    [
                        "caption" => "My linked products",
                        "name" => "My_Shop.products.sync",
                        "actions" => ['view','save','delete','hide_and_show_columns']
                    ],
                    [
                        "caption" => "deleted products",
                        "name" => "My_Shop.products.deleted",
                        "actions" => ['view','save','delete','sync']
                    ],
                ],
            ],
            "Seller" => [
                "children" => [
                    [
                        "caption" => "sellers",
                        "name" => "store.sellers",
                        "actions" => ['view']
                    ],
                    [
                        "caption" => "seller view",
                        "name" => "store.sellerview",
                        "actions" => ['view','send_message']
                    ],
                ]
            ],
            "Orders" => [
                "children" => [
                    "Sync Orders" => [
                        "caption" => "Sync Orders",
                        "name" => "order.sync",
                        "actions" => ['view','payment_completion']
                    ],
                    "Direct Orders" => [
                        "caption" => "Direct Orders",
                        "name" => "order.direct",
                        "actions" => ['view','delete','payment_completion']
                    ],
                    "Orders Details" => [
                        "caption" => "Orders details",
                        "name" => "order.details",
                        "actions" => ['view','refund_request','refund_details','review','generate_invoice']
                    ],
                ],
            ],
            "my account settings" => [
                "children" => [
                    "my account data" => [
                        "caption" => "my account data",
                        "name" => "my_account.data",
                        "actions" => ['view','update','add_address','enable_address','edit_address','delete_address']
                    ],
                    "Employees" => [
                        "caption" => "employees",
                        "name" => "my_account.employees",
                        "actions" => ['view','add','edit','delete','enabled']
                    ],
                    "my_wallet" => [
                        "caption" => "my_wallet",
                        "name" => "my_account.my_wallet",
                        "actions" => ['view','recharge','transaction_history']
                    ],
                    "my_loyalty_point" => [
                        "caption" => "my_loyalty_point",
                        "name" => "my_account.my_loyalty_point",
                        "actions" => ['view','convert_to_currency']
                    ],
                    "wish_list" => [
                        "caption" => "wish_list",
                        "name" => "my_account.wish_list",
                        "actions" => ['view']
                    ],
                    "support_ticket" => [
                        "caption" => "support_ticket",
                        "name" => "my_account.support_ticket",
                        "actions" => ['view','add','show_ticket','delete','replay','close_ticket']
                    ],
                    "chat_with_seller" => [
                        "caption" => "chat_with_seller",
                        "name" => "my_account.chat_with_seller",
                        "actions" => ['view','send_message']
                    ],
                    "chat_with_delivery_man" => [
                        "caption" => "chat_with_delivery_man",
                        "name" => "my_account.chat_with_delivery_man",
                        "actions" => ['view','send_message']
                    ],
                    "Settings for linking my online store API" => [
                        "caption" => "Settings for linking my online store API",
                        "name" => "my_account.linking_store_API",
                        "actions" => ['view','sallah','zid']
                    ],
                    "subscriptions" => [
                        "caption" => "subscriptions",
                        "name" => "my_account.subscriptions",
                        "actions" => ['view','subscribe']
                    ],
                ]
            ],
        ];
        if(session('user_type') == 'delegate'){
            $currentEmployeePermissions = json_decode(auth('delegatestore')->user()->module_access, true);

            $filteredPages = [];

            foreach ($pages as $category => $data) {
                $filteredChildren = [];

                foreach ($data['children'] as $child) {
                    $filteredActions = array_filter($child['actions'], function ($action) use ($currentEmployeePermissions, $child) {
                        return in_array($child['name'] . '.' . $action, $currentEmployeePermissions);
                    });

                    if (!empty($filteredActions)) {
                        $filteredChildren[] = [
                            'caption' => $child['caption'],
                            'name' => $child['name'],
                            'actions' => array_values($filteredActions),
                        ];
                    }
                }

                if (!empty($filteredChildren)) {
                    $filteredPages[$category] = ['children' => $filteredChildren];
                }
            }
            $pages = $filteredPages;
        }
        $inputs = [
        ];
        return view('web-views.delegate.add', compact('role','pages','inputs','employees'));
    }

    public function store(Request $request){
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:delegated_stores,email',
        ]);
        if ($validator->fails()) {
            Toastr::error(Helpers::translate('Email is already in use'));
            return redirect()->back()->withInput();
        }
        $store = User::find($storeId);
        //Generate Password
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, strlen($characters) - 1)];
        }
        $link =  env('APP_URL').'/customer/auth/login';

        $encryptedPassword = Hash::make($randomPassword);

        $delegate = new DelegatedStore;
        $delegate->name = $request->name;
        $delegate->email = $request->email;
        $delegate->phone = $request->phone;
        $delegate->password = $encryptedPassword;
        $delegate->store_id = $store->id;
        $web = BusinessSetting::all();
        $emailData = [
            'link' => $link,
            'delegateEmail' => $delegate->email,
            'randomPassword' => $randomPassword,
            'storeName' => $store->store_informations['company_name'] ?? $store->name,
            'logourl' => Helpers::get_settings($web, 'shop_header_icon')->value,
        ];
        $mail = new \App\Mail\MasfufatMail($emailData);
        $mail->setView('web-views.delegate.welcome-email');
        Mail::to($delegate->email)->send($mail);
        $delegate->save();
        if($request->from_employee != ''){
            $emp = DelegatedStore::where('id',$request->from_employee)->first();
            $delegate->module_access = $emp->module_access;
            $delegate->input_access = $emp->input_access;
            $delegate->save();

        }else{
            $m = "";
            foreach($request->modules as $module){
                if($module){
                    $m .= $module;
                    $m .= ",";
                }
            }
            $m = explode(',',$m);
            $inputs = "";
            // foreach($request->inputs as $inputsodule){
            //     if($inputsodule){
            //         $inputs .= $inputsodule;
            //         $inputs .= ",";
            //     }
            // }
            // $inputs = explode(',',$inputs);
            DB::table('delegated_stores')->where(['id' => $delegate->id])->update([
                'module_access' => json_encode($m),
                'input_access' => $inputs,
            ]);
        }
        Toastr::success(Helpers::translate('The invitation has been sent to the authorized person email'));

        return redirect()->route('delegates.list');
    }

    public function status(Request $request)
    {
        if(!Helpers::store_module_permission_check('my_account.employees.enabled')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $delegate = DelegatedStore::find($request->id);
        $delegate->status = $request->status;
        $delegate->save();
        return response()->json([], 200);
    }

    public function delete(Request $request,$id)
    {
        if(!Helpers::store_module_permission_check('my_account.employees.delete')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $delegate = DelegatedStore::where(['store_id' => $storeId , 'id' => $id])->first();
        $delegate->delete();

        Toastr::success(Helpers::translate('employee removed!'));
        return back();
    }

    public function edit($id)
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        if(!Helpers::store_module_permission_check('my_account.employees.edit')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }

        $delegate = DelegatedStore::where(['store_id' => $storeId , 'id' => $id])->first();
        if(!$delegate){
            return back();
        }
        if(session('user_type') == 'delegate'){
            $currentDelegateId = auth('delegatestore')->user()->id;
            $delegate = DelegatedStore::where(['store_id' => $storeId , 'id' => $id])
                                       ->whereNotIn('id', [$currentDelegateId])
                                       ->first();
            if(!$delegate){
                return back();
            }
        }
        $employees = DelegatedStore::where('store_id',$storeId)->where('id', '!=', $delegate->id)->get();
        $role = DelegatedStore::where(['store_id' => $storeId , 'id' => $id])->first(['id', 'name', 'module_access','input_access']);
        $pages = [
            "Home" => [
                "children" => [
                    [
                        "caption" => "Home Page",
                        "name" => "store.home",
                        "actions" => ['view','show_notifications','show_cart','show_education']
                    ],
                ],
            ],
            "products" => [
                "children" => [
                    [
                        "caption" => "Products",
                        "name" => "store.products",
                        "actions" => ['view','add_to_cart','syncc']
                    ],
                    [
                        "caption" => "Products Details",
                        "name" => "store.products_details",
                        "actions" => ['view','add_to_cart','syncc']
                    ],
                ],
            ],
            "My Shop" => [
                "children" => [
                    [
                        "caption" => "My linked products (in pending)",
                        "name" => "My_Shop.products.pending",
                        "actions" => ['view','save','delete','save_and_sync','settings_of_synchronization']
                    ],
                    [
                        "caption" => "My linked products",
                        "name" => "My_Shop.products.sync",
                        "actions" => ['view','save','delete','hide_and_show_columns']
                    ],
                    [
                        "caption" => "deleted products",
                        "name" => "My_Shop.products.deleted",
                        "actions" => ['view','save','delete','sync']
                    ],
                ],
            ],
            "Seller" => [
                "children" => [
                    [
                        "caption" => "sellers",
                        "name" => "store.sellers",
                        "actions" => ['view']
                    ],
                    [
                        "caption" => "seller view",
                        "name" => "store.sellerview",
                        "actions" => ['view','send_message']
                    ],
                ]
            ],
            "Orders" => [
                "children" => [
                    "Sync Orders" => [
                        "caption" => "Sync Orders",
                        "name" => "order.sync",
                        "actions" => ['view','payment_completion']
                    ],
                    "Direct Orders" => [
                        "caption" => "Direct Orders",
                        "name" => "order.direct",
                        "actions" => ['view','delete','payment_completion']
                    ],
                    "Orders Details" => [
                        "caption" => "Orders details",
                        "name" => "order.details",
                        "actions" => ['view','refund_request','refund_details','review','generate_invoice']
                    ],
                ],
            ],
            "my account settings" => [
                "children" => [
                    "my account data" => [
                        "caption" => "my account data",
                        "name" => "my_account.data",
                        "actions" => ['view','update','add_address','enable_address','edit_address','delete_address']
                    ],
                    "Employees" => [
                        "caption" => "employees",
                        "name" => "my_account.employees",
                        "actions" => ['view','add','edit','delete','enabled']
                    ],
                    "my_wallet" => [
                        "caption" => "my_wallet",
                        "name" => "my_account.my_wallet",
                        "actions" => ['view','recharge','transaction_history']
                    ],
                    "my_loyalty_point" => [
                        "caption" => "my_loyalty_point",
                        "name" => "my_account.my_loyalty_point",
                        "actions" => ['view','convert_to_currency']
                    ],
                    "wish_list" => [
                        "caption" => "wish_list",
                        "name" => "my_account.wish_list",
                        "actions" => ['view']
                    ],
                    "support_ticket" => [
                        "caption" => "support_ticket",
                        "name" => "my_account.support_ticket",
                        "actions" => ['view','add','show_ticket','delete','replay','close_ticket']
                    ],
                    "chat_with_seller" => [
                        "caption" => "chat_with_seller",
                        "name" => "my_account.chat_with_seller",
                        "actions" => ['view','send_message']
                    ],
                    "chat_with_delivery_man" => [
                        "caption" => "chat_with_delivery_man",
                        "name" => "my_account.chat_with_delivery_man",
                        "actions" => ['view','send_message']
                    ],
                    "Settings for linking my online store API" => [
                        "caption" => "Settings for linking my online store API",
                        "name" => "my_account.linking_store_API",
                        "actions" => ['view','sallah','zid']
                    ],
                    "subscriptions" => [
                        "caption" => "subscriptions",
                        "name" => "my_account.subscriptions",
                        "actions" => ['view','subscribe']
                    ],
                ]
            ],
        ];
        if(session('user_type') == 'delegate'){
            $currentEmployeePermissions = json_decode(auth('delegatestore')->user()->module_access, true);

            $filteredPages = [];

            foreach ($pages as $category => $data) {
                $filteredChildren = [];

                foreach ($data['children'] as $child) {
                    $filteredActions = array_filter($child['actions'], function ($action) use ($currentEmployeePermissions, $child) {
                        return in_array($child['name'] . '.' . $action, $currentEmployeePermissions);
                    });

                    if (!empty($filteredActions)) {
                        $filteredChildren[] = [
                            'caption' => $child['caption'],
                            'name' => $child['name'],
                            'actions' => array_values($filteredActions),
                        ];
                    }
                }

                if (!empty($filteredChildren)) {
                    $filteredPages[$category] = ['children' => $filteredChildren];
                }
            }
            $pages = $filteredPages;
        }
        $inputs = [];
        return view('web-views.delegate.edit', compact('delegate','role','pages','inputs','employees'));
    }
    public function update(Request $request){
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $delegate = DelegatedStore::where(['store_id' => $storeId, 'id' => $request->id])->first();
        $delegate->name = $request->name;
        $delegate->email = $request->email;
        $delegate->phone = $request->phone;
        if ($request['password'] == null) {
            $delegate->password = $delegate->password;
        } else {
        $delegate->password =  Hash::make($request->password);
        }
        $delegate->save();
        $m = "";
        foreach($request->modules as $module){
            if($module){
                $m .= $module;
                $m .= ",";
            }
        }
        $m = explode(',',$m);
        $inputs = "";
        // foreach($request->inputs as $inputsodule){
        //     if($inputsodule){
        //         $inputs .= $inputsodule;
        //         $inputs .= ",";
        //     }
        // }
        // $inputs = explode(',',$inputs);
        DB::table('delegated_stores')->where(['id' => $request->id])->update([
            'module_access' => json_encode($m),
            'input_access' => $inputs,
        ]);
        Toastr::success(Helpers::translate('employee uptaded!'));
        return back();

    }

    public function update_role(Request $request, $id){

        $m = "";
        foreach($request->modules as $module){
            if($module){
                $m .= $module;
                $m .= ",";
            }
        }
        $m = explode(',',$m);
        $inputs = "";
        // foreach($request->inputs as $inputsodule){
        //     if($inputsodule){
        //         $inputs .= $inputsodule;
        //         $inputs .= ",";
        //     }
        // }
        // $inputs = explode(',',$inputs);
        DB::table('delegated_stores')->where(['id' => $id])->update([
            'module_access' => json_encode($m),
            'input_access' => $inputs,
        ]);
        Toastr::success(Helpers::translate('Role updated successfully!'));
        return back();
    }

    public function delegate_update(Request $request){
        if($request->password !== $request->password_confirmation) {
            Toastr::warning('passwords not match!');
            return back();
        }
        $delegate = DelegatedStore::find(auth('delegatestore')->user()->id);
        $delegate->update(($request)->all());
        if($request->email){
            $delegate->email = $request->email;
        }
        if($request->password){
            $delegate->password = Hash::make($request->password);
        }
        $delegate->save();
        Toastr::success(Helpers::translate('changes saved!'));
        return back();
    }
}
