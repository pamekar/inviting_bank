<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\Account;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::where('type', 'transfer')->get();
        $accounts = Account::all();

        foreach ($transactions as $transaction) {
            Transfer::create([
                'transaction_id' => $transaction->id,
                'source_account_id' => $transaction->account_id,
                'destination_account_id' => $accounts->random()->id,
            ]);
        }
    }
}