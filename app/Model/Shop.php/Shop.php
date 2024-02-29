<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $casts = [
        'seller_id ' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function scopeActive($query){
        return $query->whereHas('seller', function ($query) {
            $query->where(['status' => 'approved']);
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('seller', function (Builder $builder) {
            $builder = $builder->with(['seller'=>function($query){
                $query->select('id','show_sellers_section');
            }]);
        });
    }
}
