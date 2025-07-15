<?php

namespace App\Filament\Imports;

use App\Enum\Court;
use App\Enum\LegalOutcome;
use App\Models\AffirmanceRate;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AffirmanceRateImporter extends Importer
{
    protected static ?string $model = AffirmanceRate::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('court')
                ->label('Court')
                ->requiredMapping()
                ->rules(['required', 'max:50', Rule::in(array_column(Court::cases(), 'value'))]),
            ImportColumn::make('outcome')
                ->label('Outcome')
                ->requiredMapping()
                ->rules(['required', 'max:50', Rule::in(array_column(LegalOutcome::cases(), 'value'))]),
            ImportColumn::make('total')
                ->label('Total Decisions')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'min:0']),
            ImportColumn::make('month_year')
                ->label('Month & Year')
                ->helperText('Dates default to 1st. Use YYYY-MM-DD.')
                ->requiredMapping()
                ->rules(['required', 'date_format:Y-m-d']),
        ];
    }

    public function resolveRecord(): ?AffirmanceRate
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
        
        return AffirmanceRate::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'court' => $this->data['court'],
            'outcome' => $this->data['outcome'],
            'month_year' => $this->data['month_year'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your affirmance rate import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
