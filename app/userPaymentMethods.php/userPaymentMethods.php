<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userPaymentMethods extends Model
{
    use HasFactory;
    protected $casts = [
        "payment_methods"=>'array',
    ];
}
