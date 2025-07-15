<?php

namespace App\Filament\Exports;

use App\Models\AffirmanceRate;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AffirmanceRateExporter extends Exporter
{
    protected static ?string $model = AffirmanceRate::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('court')->label('court'),
            ExportColumn::make('outcome')->label('outcome'),
            ExportColumn::make('total')->label('total'),
            ExportColumn::make('month_year')->label('month_year'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your affirmance data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
