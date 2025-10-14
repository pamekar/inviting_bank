<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            AccountTierSeeder::class,
            TransactionFeeSeeder::class,
            UserSeeder::class,
            BeneficiarySeeder::class,
            TransactionSeeder::class,
            WithdrawalSeeder::class,
            DepositSeeder::class,
            TransferSeeder::class,
            UtilityPaymentSeeder::class,
            PendingAuthorizationSeeder::class,
            AuditLogSeeder::class,
            DeviceSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}