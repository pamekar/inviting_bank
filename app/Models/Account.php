<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_tier_id',
        'account_number',
        'type',
        'balance',
        'status',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountTier()
    {
        return $this->belongsTo(AccountTier::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
