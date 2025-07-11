<?php

namespace App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\AppealedCaseResource;
use App\Models\AppealedCase;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreateAppealedCase extends CreateRecord
{
    protected static string $resource = AppealedCaseResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create Appealed Case';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = AppealedCase::where('status', $data['status'])
            ->where('case_type', $data['case_type'])
            ->where('month_year', $data['month_year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
                ->body('Combination of status, case type, month & year already exists.')
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
