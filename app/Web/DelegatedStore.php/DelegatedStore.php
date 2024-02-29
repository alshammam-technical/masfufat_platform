<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegatedStore extends Model
{
    use HasFactory;
    public function store()
    {
        return $this->belongsTo(User::class);
    }
}
