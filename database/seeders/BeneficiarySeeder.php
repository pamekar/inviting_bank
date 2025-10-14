<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Beneficiary;
use App\Models\Account;

class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $accounts = Account::all();

        foreach ($users as $user) {
            $beneficiaries = $accounts->random(rand(1, 10));
            foreach ($beneficiaries as $beneficiary) {
                Beneficiary::create([
                    'user_id' => $user->id,
                    'beneficiary_account_id' => $beneficiary->id,
                    'nickname' => fake()->name(),
                ]);
            }
        }
    }
}