<?php

namespace App\Filament\Resources\IndigentLitigantResource\Pages;

use App\Filament\Exports\IndigentLitigantExporter;
use App\Filament\Imports\IndigentLitigantImporter;
use App\Filament\Resources\IndigentLitigantResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListIndigentLitigants extends ListRecords
{
    protected static string $resource = IndigentLitigantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(IndigentLitigantExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Indigents Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: If you'll use this file for importing, make sure to change the date format to YYYY-MM-DD.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_indigent::litigant')),
            ImportAction::make()
                ->importer(IndigentLitigantImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Indigents Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_indigent::litigant')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
