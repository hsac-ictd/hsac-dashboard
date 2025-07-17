<?php

namespace App\Filament\Resources\AffirmanceRateResource\Pages;

use App\Enum\Court;
use App\Filament\Exports\AffirmanceRateExporter;
use App\Filament\Imports\AffirmanceRateImporter;
use App\Filament\Resources\AffirmanceRateResource;
use App\Filament\Resources\AffirmanceRateResource\Widgets\Affirmance;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListAffirmanceRates extends ListRecords
{
    use ExposesTableToWidgets;
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

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'court_of_appeals' => Tab::make('Court of Appeals')->modifyQueryUsing(fn (Builder $query) => $query->where('court', Court::CA->value)),
            'supreme_court' => Tab::make('Supreme Court')->modifyQueryUsing(fn (Builder $query) => $query->where('court', Court::SC->value)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Affirmance::class,
        ];
    }
}
