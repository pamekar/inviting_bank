<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionFee;

class TransactionFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionFee::create([
            'name' => 'Intra-bank Transfer Fee (Tier 1)',
            'type' => 'transfer',
            'min_amount' => 0,
            'max_amount' => 50000,
            'fee' => 25,
        ]);

        TransactionFee::create([
            'name' => 'Intra-bank Transfer Fee (Tier 2)',
            'type' => 'transfer',
            'min_amount' => 50001,
            'max_amount' => 1000000,
            'fee' => 50,
        ]);

        TransactionFee::create([
            'name' => 'Intra-bank Transfer Fee (Tier 3)',
            'type' => 'transfer',
            'min_amount' => 1000001,
            'max_amount' => null,
            'fee' => 100,
        ]);

        TransactionFee::create([
            'name' => 'ATM Withdrawal Fee',
            'type' => 'withdrawal',
            'fee' => 65,
        ]);

        TransactionFee::create([
            'name' => 'OTC Withdrawal Fee',
            'type' => 'withdrawal',
            'fee' => 100,
        ]);
    }
}