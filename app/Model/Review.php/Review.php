<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    protected $casts = [
        'product_id'  => 'integer',
        'customer_id' => 'integer',
        'rating'      => 'integer',
        'status'      => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    protected $appends = [
        'attachment_url',
        'customer_name',
        'customer_image_url',
    ];

    protected $fillable = [
        'product_id',
        'customer_id',
        'delivery_man_id',
        'order_id',
        'comment',
        'attachment',
        'rating',
        'status',
    ];

    public function scopeActive($query)
    {
        $query->where('status',1);
    }
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getAttachmentUrlAttribute()
    {
        $atturls = [];
        foreach(json_decode($this->attachment) ?? [] as $att){
            $atturls[] = asset('storage/app/public/review').'/'.$att;
        }
        return $atturls;
    }

    public function getCustomerNameAttribute(){
        return $this->customer->name ?? null;
    }

    public function getCustomerImageUrlAttribute(){
        if ($this->customer && $this->customer->image) {
        return asset('storage/app/public/user').'/'.$this->customer->image ?? null;
        }
        return null;
    }


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder) {
            if(str_contains(url()->current(), url('/').'/admin') || str_contains(url()->current(), url('/').'/seller') || str_contains(url()->current(), url('/').'/api/v2'))
            {
                $builder;
            }else{
                $builder->where('status',1);
            }
        });
    }
}
