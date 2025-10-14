<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            DatabaseNotification::create([
                'id' => fake()->uuid(),
                'type' => 'App\Notifications\TransactionNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'message' => 'Your transaction was successful.',
                    'amount' => fake()->numberBetween(1000, 100000),
                ]),
            ]);
        }
    }
}