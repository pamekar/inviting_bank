<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendingAuthorization;
use App\Models\User;
use App\Models\Transaction;

class PendingAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $transactions = Transaction::all();

        for ($i = 0; $i < 8; $i++) {
            $user = $users->random();
            $transaction = $transactions->random();
            PendingAuthorization::create([
                'user_id' => $user->id,
                'authorization_type' => $transaction->type,
                'transaction_id' => $transaction->id,
                'transaction_details' => json_encode($transaction),
                'expires_at' => now()->addMinutes(15),
            ]);
        }
    }
}