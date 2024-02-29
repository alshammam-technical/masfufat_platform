<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $casts = [
        "shipping_info"=>'array',
        'videos_indexing' => 'array',
        'images' => 'array',
        'videos' => 'array',
        'files' => 'array',
    ];

}
