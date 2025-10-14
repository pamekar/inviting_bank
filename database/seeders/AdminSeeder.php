<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@nigerianbank.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('super-admin');

        $user = User::create([
            'name' => 'Finance Admin',
            'email' => 'finance@nigerianbank.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('finance-admin');
    }
}
