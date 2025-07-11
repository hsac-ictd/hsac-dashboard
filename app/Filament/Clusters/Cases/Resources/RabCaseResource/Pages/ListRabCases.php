<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\RabCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRabCases extends ListRecords
{
    protected static string $resource = RabCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
