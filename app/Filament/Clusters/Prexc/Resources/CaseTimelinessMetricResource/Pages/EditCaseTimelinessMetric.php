<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;

use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource;
use App\Models\CaseTimelinessMetric;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditCaseTimelinessMetric extends EditRecord
{
    protected static string $resource = CaseTimelinessMetricResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Timeliness Metric Data';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $not_unique = CaseTimelinessMetric::where('case_type', $data['case_type'])
            ->where('month_year', $data['month_year'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not update')
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
