<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Deposit;

class DepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::where('type', 'deposit')->get();

        foreach ($transactions as $transaction) {
            Deposit::create([
                'transaction_id' => $transaction->id,
                'source' => fake()->randomElement(['mobile_money', 'bank_transfer', 'salary', 'cash']),
            ]);
        }
    }
}