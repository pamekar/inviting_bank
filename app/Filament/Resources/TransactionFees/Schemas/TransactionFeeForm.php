<?php

namespace App\Filament\Resources\TransactionFees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionFeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('min_amount')
                    ->numeric(),
                TextInput::make('max_amount')
                    ->numeric(),
                TextInput::make('fee')
                    ->required()
                    ->numeric(),
            ]);
    }
}
