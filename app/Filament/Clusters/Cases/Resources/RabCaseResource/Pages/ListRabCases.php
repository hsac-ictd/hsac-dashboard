<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;

use App\Enum\CaseType;
use App\Filament\Clusters\Cases\Resources\RabCaseResource;
use App\Filament\Clusters\Cases\Resources\RabCaseResource\Widgets\TotalRabCases;
use App\Filament\Exports\RabCaseExporter;
use App\Filament\Imports\RabCaseImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListRabCases extends ListRecords
{
    use ExposesTableToWidgets;

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

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'REM' => Tab::make('REM')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::REM->value)),
            'HOA' => Tab::make('HOA')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::HOA->value)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TotalRabCases::class,
        ];
    }
}
