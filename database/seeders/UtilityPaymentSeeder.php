<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\UtilityPayment;
use App\Models\Account;

class UtilityPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::all();

        for ($i = 0; $i < 150; $i++) {
            $account = $accounts->random();
            $transaction = Transaction::create([
                'account_id' => $account->id,
                'type' => 'utility_payment',
                'amount' => fake()->numberBetween(2000, 50000),
                'status' => fake()->randomElement(['completed', 'pending', 'failed']),
                'description' => 'Utility Payment',
            ]);

            UtilityPayment::create([
                'transaction_id' => $transaction->id,
                'biller' => fake()->randomElement(['NEPA', 'LagosWater', 'MTN', 'Airtel']),
                'customer_reference' => fake()->numerify('##########'),
            ]);
        }
    }
}