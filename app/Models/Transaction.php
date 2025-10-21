<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'status',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transfer()
    {
        return $this->hasOne(Transfer::class);
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }

    public function withdrawal()
    {
        return $this->hasOne(Withdrawal::class);
    }

    public function utilityPayment()
    {
        return $this->hasOne(UtilityPayment::class);
    }
}