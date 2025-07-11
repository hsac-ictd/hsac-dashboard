<?php

namespace App\Filament\Resources\IndigentLitigantResource\Pages;

use App\Filament\Resources\IndigentLitigantResource;
use App\Models\IndigentLitigant;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreateIndigentLitigant extends CreateRecord
{
    protected static string $resource = IndigentLitigantResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create Indigents Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = IndigentLitigant::where('rab', $data['rab'])
            ->where('month_year', $data['month_year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
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
