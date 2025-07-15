<?php

namespace App\Filament\Imports;

use App\Enum\Branch;
use App\Enum\CaseStatus;
use App\Enum\CaseType;
use App\Models\RabCase;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RabCaseImporter extends Importer
{
    protected static ?string $model = RabCase::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('rab')
                ->label('RAB')
                ->requiredMapping()
                ->rules(['required', 'max:50', Rule::in(array_column(Branch::cases(), 'value'))]),
            ImportColumn::make('status')
                ->label('Status (Filed or Resolved)')
                ->requiredMapping()
                ->rules(['required', 'max:20', Rule::in(array_column(CaseStatus::cases(), 'value'))]),
            ImportColumn::make('case_type')
                ->label('Case Type (REM or HOA)')
                ->requiredMapping()
                ->rules(['required', 'max:20', Rule::in(array_column(CaseType::cases(), 'value'))]),
            ImportColumn::make('total')
                ->label('Total Cases')
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

    public function resolveRecord(): ?RabCase
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

        return RabCase::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'rab' => $this->data['rab'],
            'status' => $this->data['status'],
            'case_type' => $this->data['case_type'],
            'month_year' => $this->data['month_year'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your rab case data import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
