<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Order;
use App\Model\Seller;

class external_orders extends Model
{
    use HasFactory;

    protected $table = 'external_orders';

    protected $casts = [
        "items"=>'array',
        "customer"=>'array',
        "qtys"=>'array',
        "details"=>'array',
    ];


    public function user()
    {
        return $this->hasOne(User::class,'id','seller_id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class,'id','seller_id');
    }

    public function getOrderAttribute()
    {
        return Order::where('ext_order_id',$this->id)->first();
    }
}
