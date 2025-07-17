<?php

namespace App\Filament\Exports;

use App\Models\MonthlyCaseWorkload;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MonthlyCaseWorkloadExporter extends Exporter
{
    protected static ?string $model = MonthlyCaseWorkload::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('total_disposed')->label('total_disposed'),
            ExportColumn::make('total_handled')->label('total_handled'),
            ExportColumn::make('month_year')->label('month_year'),
            ExportColumn::make('year')->label('year'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your disposed & handled data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
