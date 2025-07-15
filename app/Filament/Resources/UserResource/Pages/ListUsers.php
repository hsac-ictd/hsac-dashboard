<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(UserExporter::class)
                ->label('Export')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export User Data')
                ->color('gray')
                ->modalDescription("🙋🏻 Heads up: Existing passwords remain unchanged. New users will have the default password as 'password'.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('export_user')),
            ImportAction::make()
                ->importer(UserImporter::class)
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import User Data')
                ->modalIconColor('warning')
                ->color('warning')
                ->modalDescription("⚠️ Warning: This action will update the database. Please ensure all entries are accurate before proceeding.")
                ->modalWidth(MaxWidth::TwoExtraLarge)
                ->visible(fn (): bool => Auth::user()->can('import_user')),
            Actions\CreateAction::make()
                ->label('New')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
