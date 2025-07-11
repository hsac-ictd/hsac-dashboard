<?php

namespace App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Pages;

use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonthlyCaseWorkloads extends ListRecords
{
    protected static string $resource = MonthlyCaseWorkloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
