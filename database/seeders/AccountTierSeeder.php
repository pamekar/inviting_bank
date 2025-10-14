<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountTier;

class AccountTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountTier::create([
            'name' => 'Basic',
            'daily_withdrawal_limit' => 500000,
            'daily_transfer_limit' => 1000000,
            'monthly_transaction_limit' => 50,
            'maintenance_fee' => 500,
        ]);

        AccountTier::create([
            'name' => 'Premium',
            'daily_withdrawal_limit' => 2000000,
            'daily_transfer_limit' => 5000000,
            'maintenance_fee' => 2000,
        ]);

        AccountTier::create([
            'name' => 'VIP',
            'daily_withdrawal_limit' => 10000000,
            'daily_transfer_limit' => 50000000,
            'maintenance_fee' => 5000,
        ]);
    }
}