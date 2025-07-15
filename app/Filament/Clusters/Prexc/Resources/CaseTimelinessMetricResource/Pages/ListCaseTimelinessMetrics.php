<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;

use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource;
use App\Filament\Exports\CaseTimelinessMetricExporter;
use App\Filament\Imports\CaseTimelinessMetricImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListCaseTimelinessMetrics extends ListRecords
{
    protected static string $resource = CaseTimelinessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(CaseTimelinessMetricExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Timeliness Metric Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_case::timeliness::metric')),
            ImportAction::make()
                ->importer(CaseTimelinessMetricImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Timeliness Metric Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_case::timeliness::metric')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
