<?php

namespace App\Model;
use App\SupportTicketAttachment;

use Illuminate\Database\Eloquent\Model;

class SupportTicketConv extends Model
{
    protected $casts = [
        'support_ticket_id' => 'integer',
        'admin_id'          => 'integer',
        'position'          => 'integer',

        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    public function attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'ticket_conv_id');
    }

    public function ticket_attachments()
    {
        return $this->hasMany(SupportTicketAttachment::class, 'ticket_id', 'support_ticket_id');
    }
}
