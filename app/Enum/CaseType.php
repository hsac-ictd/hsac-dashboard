<?php

namespace App\Enum;

enum CaseType: string
{
    //Internal name with a value that will be stored in DB or used as a display key
    case REM = 'REM'; 
    case HOA = 'HOA';
    case Appealed = 'Appealed';
    case TPZ = 'TPZ';

    //The label can be changed here for the options; but the value to be used to store in DB is the case (up there) 👆
    public function label(): string
    {
        return match ($this) {
            self::REM => 'REM',
            self::HOA => 'HOA',
            self::Appealed => 'Appealed',
            self::TPZ => 'TPZ',
        };
    }

    //This will return the array with key value pair; to be used in Select inputs
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($caseType) => [
            $caseType->value => $caseType->label(),
        ])->toArray();
    }

    public static function optionsForRabCases(): array
    {
        return collect(self::cases())
            ->reject(fn($caseType) => in_array($caseType, [self::Appealed, self::TPZ]))
            ->mapWithKeys(fn($caseType) => [
                $caseType->value => $caseType->label(),
            ])
            ->toArray();
    }

    public static function optionsForAppealedCases(): array
    {
        return collect(self::cases())
            ->reject(fn($caseType) => in_array($caseType, [self::Appealed]))
            ->mapWithKeys(fn($caseType) => [
                $caseType->value => $caseType->label(),
            ])
            ->toArray();
    }

    public static function optionsForTimeliness(): array
    {
        return collect(self::cases())
            ->reject(fn($caseType) => in_array($caseType, [self::TPZ]))
            ->mapWithKeys(fn($caseType) => [
                $caseType->value => $caseType->label(),
            ])->toArray();
    }
}
