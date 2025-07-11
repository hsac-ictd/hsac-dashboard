<?php

namespace App\Filament\Resources\AffirmanceRateResource\Pages;

use App\Filament\Resources\AffirmanceRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAffirmanceRates extends ListRecords
{
    protected static string $resource = AffirmanceRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
