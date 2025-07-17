<?php

namespace App\Filament\Exports;

use App\Models\CaseTimelinessMetric;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CaseTimelinessMetricExporter extends Exporter
{
    protected static ?string $model = CaseTimelinessMetric::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('case_type')->label('case_type'),
            ExportColumn::make('total_disposed')->label('total_disposed'),
            ExportColumn::make('total_ripe')->label('total_ripe'),
            ExportColumn::make('month_year')->label('month_year'),
            ExportColumn::make('year')->label('year'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your case timeliness metric data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
