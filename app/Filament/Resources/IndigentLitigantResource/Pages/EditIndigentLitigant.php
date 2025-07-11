<?php

namespace App\Filament\Resources\IndigentLitigantResource\Pages;

use App\Filament\Resources\IndigentLitigantResource;
use App\Models\IndigentLitigant;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditIndigentLitigant extends EditRecord
{
    protected static string $resource = IndigentLitigantResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Indigents Data';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $not_unique = IndigentLitigant::where('rab', $data['rab'])
            ->where('month_year', $data['month_year'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not update')
                ->body('Combination of rab, month & year already exists.')
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
