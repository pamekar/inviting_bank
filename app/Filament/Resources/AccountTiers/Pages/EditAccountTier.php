<?php

namespace App\Filament\Resources\AccountTiers\Pages;

use App\Filament\Resources\AccountTiers\AccountTierResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAccountTier extends EditRecord
{
    protected static string $resource = AccountTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
