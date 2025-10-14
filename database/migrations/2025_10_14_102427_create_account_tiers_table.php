<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('daily_withdrawal_limit');
            $table->unsignedBigInteger('daily_transfer_limit');
            $table->unsignedInteger('monthly_transaction_limit')->nullable();
            $table->unsignedInteger('maintenance_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_tiers');
    }
};