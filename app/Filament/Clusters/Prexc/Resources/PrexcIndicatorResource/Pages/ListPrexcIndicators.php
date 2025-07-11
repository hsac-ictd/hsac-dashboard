<?php

namespace App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\Pages;

use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrexcIndicators extends ListRecords
{
    protected static string $resource = PrexcIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
