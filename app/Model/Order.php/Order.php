<?php

namespace App\Model;

use App\external_orders;
use App\User;
use App\Model\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $casts = [
        'order_amount' => 'float',
        'discount_amount' => 'float',
        'customer_id' => 'integer',
        'shipping_address' => 'integer',
        'shipping_cost' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'billing_address'=> 'integer',
        'extra_discount'=>'float',
        'delivery_man_id'=>'integer',
        'shipping_method_id'=>'integer',
        'seller_id'=>'integer',
        'shipping_info'=>'json',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class)->orderBy('seller_id', 'ASC');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function seller_()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function sellerName()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }
    public function billingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'billing_address');
    }

    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id');
    }

    public function delivery_man_review()
    {
        return $this->hasOne(Review::class,'order_id');
    }

    public function order_transaction(){
        return $this->hasOne(OrderTransaction::class, 'order_id');
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function external_order()
    {
        return $this->hasOne(external_orders::class,'id','ext_order_id');
    }

    public function getBankInfoAttribute()
    {
        return json_decode($this->bank_details);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(function(Builder $builder){
            $builder->where('order_status','<>','deleted');
                $adminUser = auth('admin')->user();
                if(Str::contains(request()->url(), 'admin')){
                    if ($adminUser->admin_role_id == 1) {
                        return;
                    }

                    $user_role = $adminUser->role ?? null;
                    if ($user_role) {
                        User::setApplyOrderPermissionsScope(true);
                        Seller::setApplyOrderPermissionsScope(true);
                        $inputPermissions = json_decode($user_role->input_permissions, true);

                        $orderIds = explode(',', $inputPermissions['Request powers by number'][0] ?? '');

                        $sellerIds = explode(',', $inputPermissions['Order permissions by seller'][0] ?? '');
                        $storeIds = explode(',', $inputPermissions['Order permissions by store'][0] ?? '');
                        $provinceIds = explode(',', $inputPermissions['Request powers by provinces'][0] ?? '');

                        $builder->where(function ($query) use ($orderIds, $sellerIds, $storeIds, $provinceIds) {
                            $query
                                ->where(function ($q) use ($storeIds) {
                                    $q->WhereIn('customer_id', $storeIds)
                                        ->orWhereHas('external_order', function ($qq) use ($storeIds) {
                                            $qq->whereIn('seller_id', $storeIds);
                                        });
                                })
                                ->orWhere(function ($q) use ($provinceIds) {
                                    foreach ($provinceIds as $provinceId) {
                                        $q->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(shipping_address_data, '$.area_id')) = ?", [$provinceId]);
                                    }
                                })
                                ->WhereHas('seller', function ($q) use ($sellerIds) {
                                    $q->whereIn('id', $sellerIds);
                                });
                        })
                        ->orwhereIn('id', $orderIds)
                        ;
                    }
                }
        });
    }
}
