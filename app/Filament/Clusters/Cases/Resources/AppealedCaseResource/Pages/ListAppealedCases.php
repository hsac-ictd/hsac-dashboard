<?php

namespace App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\AppealedCaseResource;
use App\Filament\Exports\AppealedCaseExporter;
use App\Filament\Imports\AppealedCaseImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListAppealedCases extends ListRecords
{
    protected static string $resource = AppealedCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AppealedCaseExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Appealed Cases Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_appealed::case')),
            ImportAction::make()
                ->importer(AppealedCaseImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Appealed Cases Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_appealed::case')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
