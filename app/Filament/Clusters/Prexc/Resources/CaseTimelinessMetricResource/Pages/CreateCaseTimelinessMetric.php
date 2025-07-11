<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;

use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource;
use App\Models\CaseTimelinessMetric;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreateCaseTimelinessMetric extends CreateRecord
{
    protected static string $resource = CaseTimelinessMetricResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create Timeliness Metric Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = CaseTimelinessMetric::where('case_type', $data['case_type'])
            ->where('month_year', $data['month_year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
                ->body('Combination of case type, month & year already exists.')
                ->danger()
                ->send();

            throw ValidationException::withMessages(['Combination is not unique.']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
