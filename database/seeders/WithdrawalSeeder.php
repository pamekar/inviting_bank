<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Withdrawal;

class WithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::where('type', 'withdrawal')->get();

        foreach ($transactions as $transaction) {
            Withdrawal::create([
                'transaction_id' => $transaction->id,
                'type' => fake()->randomElement(['atm', 'otc']),
            ]);
        }
    }
}