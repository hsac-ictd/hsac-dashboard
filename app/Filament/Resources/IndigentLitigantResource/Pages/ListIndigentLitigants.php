<?php

namespace App\Filament\Resources\IndigentLitigantResource\Pages;

use App\Filament\Resources\IndigentLitigantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndigentLitigants extends ListRecords
{
    protected static string $resource = IndigentLitigantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
