<?php

namespace App\Filament\Resources\AffirmanceRateResource\Pages;

use App\Filament\Exports\AffirmanceRateExporter;
use App\Filament\Imports\AffirmanceRateImporter;
use App\Filament\Resources\AffirmanceRateResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListAffirmanceRates extends ListRecords
{
    protected static string $resource = AffirmanceRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AffirmanceRateExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Affirmance Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_affirmance::rate')),
            ImportAction::make()
                ->importer(AffirmanceRateImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Affirmance Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_affirmance::rate')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
