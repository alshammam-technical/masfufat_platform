<?php

namespace App\Model;

use App\Package;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pakcage()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
