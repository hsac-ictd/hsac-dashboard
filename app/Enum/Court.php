<?php

namespace App\Enum;

enum Court: string
{
    //CA/SC is the internal name with a value that will be stored in DB or used as a display key
    case CA = 'Court of Appeals'; 
    case SC = 'Supreme Court';

    //The label can be changed here for the options; but the value to be used to store in DB is the case (up there) 👆
    public function label(): string
    {
        return match ($this) {
            self::CA => 'Court of Appeals',
            self::SC => 'Supreme Court',
        };
    }

    //This will return the array with key value pair; to be used in Select inputs
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($court) => [
            $court->value => $court->label(),
        ])->toArray();
    }
}
