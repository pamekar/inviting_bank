<?php

namespace App\Filament\Resources\AccountTiers;

use App\Filament\Resources\AccountTiers\Pages\CreateAccountTier;
use App\Filament\Resources\AccountTiers\Pages\EditAccountTier;
use App\Filament\Resources\AccountTiers\Pages\ListAccountTiers;
use App\Filament\Resources\AccountTiers\Schemas\AccountTierForm;
use App\Filament\Resources\AccountTiers\Tables\AccountTiersTable;
use App\Models\AccountTier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AccountTierResource extends Resource
{
    protected static ?string $model = AccountTier::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AccountTierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccountTiersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccountTiers::route('/'),
            'create' => CreateAccountTier::route('/create'),
            'edit' => EditAccountTier::route('/{record}/edit'),
        ];
    }
}
