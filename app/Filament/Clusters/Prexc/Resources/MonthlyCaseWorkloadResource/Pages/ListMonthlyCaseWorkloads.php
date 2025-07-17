<?php

namespace App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Pages;

use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource;
use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Widgets\CaseWorkload;
use App\Filament\Exports\MonthlyCaseWorkloadExporter;
use App\Filament\Imports\MonthlyCaseWorkloadImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListMonthlyCaseWorkloads extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = MonthlyCaseWorkloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(MonthlyCaseWorkloadExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Disposed & Handled Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_monthly::case::workload')),
            ImportAction::make()
                ->importer(MonthlyCaseWorkloadImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Disposed & Handled Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                 ->visible(fn (): bool => Auth::user()->can('import_monthly::case::workload')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CaseWorkload::class,
        ];
    }
}
