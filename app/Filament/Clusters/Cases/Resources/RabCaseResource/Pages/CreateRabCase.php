<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\RabCaseResource;
use App\Models\RabCase;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreateRabCase extends CreateRecord
{
    protected static string $resource = RabCaseResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create RAB Case';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = RabCase::where('rab', $data['rab'])
            ->where('status', $data['status'])
            ->where('case_type', $data['case_type'])
            ->where('month_year', $data['month_year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
                ->body('Combination of RAB, status, case type, month & year already exists.')
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
