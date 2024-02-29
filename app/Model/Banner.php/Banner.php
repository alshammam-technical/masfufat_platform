<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $casts = [
        'published'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'resource_id' => 'integer',
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function product(){
        return $this->belongsTo(Product::class,'resource_id');
    }

}
