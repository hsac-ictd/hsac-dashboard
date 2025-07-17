<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;

use App\Filament\Clusters\Cases\Resources\RabCaseResource;
use App\Models\RabCase;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditRabCase extends EditRecord
{
    protected static string $resource = RabCaseResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit RAB Case';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $not_unique = RabCase::where('rab', $data['rab'])
            ->where('status', $data['status'])
            ->where('case_type', $data['case_type'])
            ->where('month_year', $data['month_year'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not update')
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
