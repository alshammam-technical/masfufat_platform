<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{

    protected $casts = [
        'price' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'seller_id' => 'integer',
        'quantity' => 'integer',
        'shipping_cost'=>'float',
        'offer'=>'array'
    ];

    public function cart_shipping(){
        return $this->hasOne(CartShipping::class,'cart_group_id','cart_group_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->where('status', 1);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function all_product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('deleted', 0);
        });
    }

}
