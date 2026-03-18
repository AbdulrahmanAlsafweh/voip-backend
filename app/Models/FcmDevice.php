<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmDevice extends Model
{
    protected $fillable = [
        'extension',
        'user_id',
        'device_id',
        'platform',
        'fcm_token',
        'app_version',
        'device_name',
        'is_active',
        'last_seen_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_seen_at' => 'datetime',
    ];
}