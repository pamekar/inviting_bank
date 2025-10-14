<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\Withdrawal;
use App\Models\Deposit;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::all();

        for ($i = 0; $i < 1500; $i++) {
            $account = $accounts->random();
            $type = fake()->randomElement(['deposit', 'withdrawal', 'transfer']);
            $transaction = Transaction::create([
                'account_id' => $account->id,
                'type' => $type,
                'amount' => fake()->numberBetween(1000, 1000000),
                'status' => fake()->randomElement(['completed', 'pending', 'failed']),
                'description' => fake()->sentence(),
            ]);

            if ($type === 'transfer') {
                Transfer::create([
                    'transaction_id' => $transaction->id,
                    'source_account_id' => $account->id,
                    'destination_account_id' => $accounts->random()->id,
                ]);
            } elseif ($type === 'withdrawal') {
                Withdrawal::create([
                    'transaction_id' => $transaction->id,
                    'type' => fake()->randomElement(['atm', 'otc']),
                ]);
            } elseif ($type === 'deposit') {
                Deposit::create([
                    'transaction_id' => $transaction->id,
                    'source' => fake()->randomElement(['mobile_money', 'bank_transfer', 'salary', 'cash']),
                ]);
            }
        }
    }
}