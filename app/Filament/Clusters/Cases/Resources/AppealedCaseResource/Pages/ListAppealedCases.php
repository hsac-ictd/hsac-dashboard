<?php

namespace App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages;

use App\Enum\CaseType;
use App\Filament\Clusters\Cases\Resources\AppealedCaseResource;
use App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Widgets\TotalAppealedCases;
use App\Filament\Exports\AppealedCaseExporter;
use App\Filament\Imports\AppealedCaseImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListAppealedCases extends ListRecords
{
    use ExposesTableToWidgets;
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

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'REM' => Tab::make('REM')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::REM->value)),
            'HOA' => Tab::make('HOA')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::HOA->value)),
            'TPZ' => Tab::make('TPZ')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::TPZ->value)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TotalAppealedCases::class,
        ];
    }
}
