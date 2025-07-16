<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;

use App\Enum\CaseType;
use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource;
use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Widgets\TimelinessMetric;
use App\Filament\Exports\CaseTimelinessMetricExporter;
use App\Filament\Imports\CaseTimelinessMetricImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListCaseTimelinessMetrics extends ListRecords
{
    use ExposesTableToWidgets;
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

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'REM' => Tab::make('REM')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::REM->value)),
            'HOA' => Tab::make('HOA')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::HOA->value)),
            'Appealed' => Tab::make('Appealed')->modifyQueryUsing(fn (Builder $query) => $query->where('case_type', CaseType::Appealed->value)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TimelinessMetric::class,
        ];
    }
}
