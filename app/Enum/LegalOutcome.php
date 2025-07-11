<?php

namespace App\Enum;

enum LegalOutcome: string
{
    case AFFIRMED = 'Affirmed';
    case REVERSED = 'Reversed';

    public function label(): string
    {
        return match($this) {
            self::AFFIRMED => 'Affirmed',
            self::REVERSED => 'Reversed',
        };
    }

    public static function options(): array
    {
         return collect(self::cases())->mapWithKeys(fn($outcome) => [
            $outcome->value => $outcome->label(),
        ])->toArray();
    }
}
