<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountTier;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basicTier = AccountTier::where('name', 'Basic')->first();
        $premiumTier = AccountTier::where('name', 'Premium')->first();
        $vipTier = AccountTier::where('name', 'VIP')->first();

        // Create 5 specific users for easy login
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@invitingbank.com",
                'password' => Hash::make('password'),
            ]);
        }

        // Create random users
        User::factory(60)->create()->each(function ($user) use ($basicTier) {
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $basicTier->id]));
        });

        User::factory(25)->create()->each(function ($user) use ($premiumTier) {
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $premiumTier->id]));
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $premiumTier->id]));
        });

        User::factory(15)->create()->each(function ($user) use ($vipTier) {
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $vipTier->id]));
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $vipTier->id]));
            $user->accounts()->save(Account::factory()->make(['account_tier_id' => $vipTier->id]));
        });
    }
}
