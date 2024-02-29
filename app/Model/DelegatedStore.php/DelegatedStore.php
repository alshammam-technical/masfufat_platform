<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DelegatedStore extends Authenticatable
{
    use HasFactory;
    public function store()
    {
        return $this->belongsTo(User::class);
    }
}
