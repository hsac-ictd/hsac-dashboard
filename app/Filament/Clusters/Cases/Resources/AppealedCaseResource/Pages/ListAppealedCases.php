<?php

namespace App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\AppealedCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppealedCases extends ListRecords
{
    protected static string $resource = AppealedCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
