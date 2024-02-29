<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $table = 'affiliates';
    protected $fillable = [
        'marketer_name',
        'marketer_email',
        'marketer_city',
        'notes',
        'commission_type',
        'amount',
        'percent',
        'apply_to',
        'show_total_sales',
    ];

    protected $casts = [
        "usage"=>'array',
    ];

    use HasFactory;
}
