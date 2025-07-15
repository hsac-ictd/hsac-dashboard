<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\RabCaseResource;
use App\Filament\Exports\RabCaseExporter;
use App\Filament\Imports\RabCaseImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListRabCases extends ListRecords
{
    protected static string $resource = RabCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(RabCaseExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export RAB Cases Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_rab::case')),
            ImportAction::make()
                ->importer(RabCaseImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import RAB Cases Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_rab::case')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
