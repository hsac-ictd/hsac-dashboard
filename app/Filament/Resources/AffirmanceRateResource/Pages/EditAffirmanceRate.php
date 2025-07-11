<?php

namespace App\Filament\Resources\AffirmanceRateResource\Pages;

use App\Filament\Resources\AffirmanceRateResource;
use App\Models\AffirmanceRate;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditAffirmanceRate extends EditRecord
{
    protected static string $resource = AffirmanceRateResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Affirmance Data';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $not_unique = AffirmanceRate::where('court', $data['court'])
            ->where('outcome', $data['outcome'])
            ->where('month_year', $data['month_year'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not update')
                ->body('Combination of court, outcome, month & year already exists.')
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
