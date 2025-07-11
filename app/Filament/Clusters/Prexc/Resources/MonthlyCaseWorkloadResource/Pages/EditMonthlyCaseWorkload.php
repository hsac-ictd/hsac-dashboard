<?php

namespace App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Pages;

use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource;
use App\Models\MonthlyCaseWorkload;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditMonthlyCaseWorkload extends EditRecord
{
    protected static string $resource = MonthlyCaseWorkloadResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Disposed & Handled Data';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $not_unique = MonthlyCaseWorkload::where('month_year', $data['month_year'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not update')
                ->body('Combination of month & year already exists.')
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
