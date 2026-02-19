<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $fillable = [
        'url',
        'method',
        'request_body',
        'response_body',
        'status_code',
        'ip_address',
        'duration_ms',
        'user_agent',
        'referer',
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'array',
    ];
}
