<?php

namespace App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\Pages;

use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource;
use App\Models\PrexcIndicator;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class CreatePrexcIndicator extends CreateRecord
{
    protected static string $resource = PrexcIndicatorResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Create PREXC Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $not_unique = PrexcIndicator::where('indicator', $data['indicator'])
            ->where('year', $data['year'])
            ->exists();

        if ($not_unique) {
            Notification::make()
                ->title('Can not create')
                ->body('Combination of indicator & year already exists.')
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
