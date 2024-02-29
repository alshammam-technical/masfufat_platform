<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Gateways\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class addonSetting extends Model
{
    use HasFactory;

    protected $table = 'addon_settings';

    protected $casts = [
        'live_values' => 'array',
        'test_values' => 'array',
        'is_active' => 'integer',
    ];

    protected $fillable = ['key_name', 'live_values', 'test_values', 'settings_type', 'mode', 'is_active', 'additional_data'];
}
