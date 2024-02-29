<?php

namespace App\Model;
use App\SupportTicketAttachment;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $casts = [
        'customer_id' => 'integer',
        'status' => 'string',
        'order_id' => 'string',

        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function conversations()
    {
        return $this->hasMany(SupportTicketConv::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'ticket_id');
    }
}
