<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'biller',
        'customer_reference',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}