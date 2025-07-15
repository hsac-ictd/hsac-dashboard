<?php

namespace App\Filament\Exports;

use App\Models\IndigentLitigant;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class IndigentLitigantExporter extends Exporter
{
    protected static ?string $model = IndigentLitigant::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('rab')->label('rab'),
            ExportColumn::make('month_year')->label('month_year'),
            ExportColumn::make('total_indigents')->label('total_indigents'),
            ExportColumn::make('with_certificate')->label('with_certificate'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your indigents data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
