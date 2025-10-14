<?php

namespace App\Filament\Resources\AccountTiers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountTierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('daily_withdrawal_limit')
                    ->required()
                    ->numeric(),
                TextInput::make('daily_transfer_limit')
                    ->required()
                    ->numeric(),
                TextInput::make('monthly_transaction_limit')
                    ->numeric(),
                TextInput::make('maintenance_fee')
                    ->required()
                    ->numeric(),
            ]);
    }
}
