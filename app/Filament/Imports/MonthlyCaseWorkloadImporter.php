<?php

namespace App\Filament\Imports;

use App\Models\MonthlyCaseWorkload;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\ValidationException;

class MonthlyCaseWorkloadImporter extends Importer
{
    protected static ?string $model = MonthlyCaseWorkload::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('total_disposed')
                ->label('Total Disposed')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'min:0']),
            ImportColumn::make('total_handled')
                ->label('Total Handled')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'min:0']),
            ImportColumn::make('month_year')
                ->label('Month & Year')
                ->helperText('Dates default to 1st. Use YYYY-MM-DD.')
                ->requiredMapping()
                ->rules(['required', 'date_format:Y-m-d']),
            ImportColumn::make('year')
                ->label('Year')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'digits:4']),
        ];
    }

    public function resolveRecord(): ?MonthlyCaseWorkload
    {
        $value = $this->data['month_year'] ?? '';

        // ✅ Check if it matches Y-m-d exactly
        $isValid = preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);

        if (!$isValid) {
            throw ValidationException::withMessages([
                'month_year' => 'The month_year must be in YYYY-MM-DD format (e.g., 2025-07-01).',
            ]);
        }

        // ✅ Then try parsing — catch invalid dates like 2025-02-30
        try {
            $this->data['month_year'] = \Carbon\Carbon::parse($value)
                ->startOfMonth()
                ->format('Y-m-d');
        } catch (\Exception $e) { 
            throw ValidationException::withMessages([
                'month_year' => 'Invalid date format or value for month_year.',
            ]);
        }

        return MonthlyCaseWorkload::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'month_year' => $this->data['month_year'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your disposed & handled data import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
