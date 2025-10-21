<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PendingAuthorization extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'authorization_type',
        'transaction_id',
        'transaction_details',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'transaction_details' => 'json',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}