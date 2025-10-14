<?php

namespace App\Filament\Resources\AccountTiers\Pages;

use App\Filament\Resources\AccountTiers\AccountTierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccountTiers extends ListRecords
{
    protected static string $resource = AccountTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
