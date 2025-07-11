<?php

namespace App\Filament\Resources\AffirmanceRateResource\Pages;

use App\Filament\Resources\AffirmanceRateResource;
use App\Models\AffirmanceRate;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreateAffirmanceRate extends CreateRecord
{
    protected static string $resource = AffirmanceRateResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create Affirmance Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = AffirmanceRate::where('court', $data['court'])
            ->where('outcome', $data['outcome'])
            ->where('month_year', $data['month_year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
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
