<?php

namespace App\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $appends = [
        'seen'
    ];

    protected $casts = [
        'status'     => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function getSeenAttribute()
    {
        return explode(',',$this->seen_by);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'sent_to');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'sent_to');
    }


}
