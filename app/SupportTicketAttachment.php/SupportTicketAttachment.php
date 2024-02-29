<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketAttachment extends Model
{
    use HasFactory;

    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/app/'.$this->file_path);
    }
}
