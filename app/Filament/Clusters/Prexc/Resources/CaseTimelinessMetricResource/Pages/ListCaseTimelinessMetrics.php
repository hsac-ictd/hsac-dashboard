<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;

use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaseTimelinessMetrics extends ListRecords
{
    protected static string $resource = CaseTimelinessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
