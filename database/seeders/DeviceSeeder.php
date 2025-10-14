<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\User;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Device::create([
                'user_id' => $user->id,
                'device_identifier' => fake()->uuid(),
                'device_name' => fake()->randomElement(['iPhone 14', 'Samsung S23', 'Chrome Windows']),
                'device_type' => fake()->randomElement(['mobile', 'web', 'tablet']),
                'is_trusted' => fake()->boolean(90),
                'last_used_at' => now(),
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
            ]);
        }
    }
}