<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;
use App\Models\Transaction;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $transactions = Transaction::all();

        for ($i = 0; $i < 800; $i++) {
            $user = $users->random();
            $transaction = $transactions->random();
            AuditLog::create([
                'user_id' => $user->id,
                'action' => fake()->randomElement(['login', 'transfer', 'withdrawal', 'admin_action', '2fa_setup']),
                'auditable_id' => $transaction->id,
                'auditable_type' => 'App\Models\Transaction',
                'old_values' => json_encode(['status' => 'pending']),
                'new_values' => json_encode(['status' => 'completed']),
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
            ]);
        }
    }
}