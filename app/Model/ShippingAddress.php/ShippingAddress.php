<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShippingAddress extends Model
{
    protected $guarded = [];
    protected $casts = [
        'customer_id' => 'integer',
        'is_billing' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope('deleted', function (Builder $builder) {
        //     if(str_contains(url()->current(), url('/').'/admin') || str_contains(url()->current(), url('/').'/seller') || str_contains(url()->current(), url('/').'/api/v2'))
        //     {
        //         $builder;
        //     }else{
        //         $builder->where('deleted',0);
        //     }
        // });
    }
}
