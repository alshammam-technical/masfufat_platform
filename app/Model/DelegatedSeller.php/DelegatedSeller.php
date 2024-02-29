<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DelegatedSeller extends Authenticatable
{
    use HasFactory;

    protected $casts = [
        'module_access' => 'array',
        'input_access' => 'array',
    ];
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
