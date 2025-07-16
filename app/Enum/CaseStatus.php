<?php

namespace App\Enum;

enum CaseStatus: string
{
    //Internal name with a value that will be stored in DB or used as a display key
    case Filed = 'Filed'; 
    case Resolved = 'Resolved';

    //The label can be changed here for the options; but the value to be used to store in DB is the case (up there) 👆
    public function label(): string
    {
        return match ($this) {
            self::Filed => 'Filed',
            self::Resolved => 'Resolved',
        };
    }

    //This will return the array with key value pair; to be used in Select inputs
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($caseStatus) => [
            $caseStatus->value => $caseStatus->label(),
        ])->toArray();
    }

    public function icon(): string
    {
        return match($this) {
            self::Filed => 'heroicon-o-document-plus',
            self::Resolved => 'heroicon-o-check-badge',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Filed => 'info',
            self::Resolved => 'success',
        };
    }
}
