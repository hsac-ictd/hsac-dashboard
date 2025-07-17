<?php

namespace App\Enum;

enum Branch: string
{
    //NCR ... etc. is the internal name with a value that will be stored in DB or used as a display key
    case NCR = 'NCR'; 
    case CAR = 'CAR';
    case I = 'I';
    case II = 'II';
    case III = 'III';
    case IVA = 'IVA';
    case IVB = 'IVB';
    case V = 'V';
    case VI = 'VI';
    case VII = 'VII';
    case VIII = 'VIII';
    case IX = 'IX';
    case X = 'X';
    case XI = 'XI';
    case XII = 'XII';
    case XIII = 'XIII';

    //The label can be changed here for the options; but the value to be used to store in DB is the case (up there) 👆
    public function label(): string
    {
        return match ($this) {
            self::NCR => 'NCR',
            self::CAR => 'CAR',
            self::I => 'I',
            self::II => 'II',
            self::III => 'III',
            self::IVA => 'IV-A',
            self::IVB => 'IV-B',
            self::V => 'V',
            self::VI => 'VI',
            self::VII => 'VII',
            self::VIII => 'VIII',
            self::IX => 'IX',
            self::X => 'X',
            self::XI => 'XI',
            self::XII => 'XII',
            self::XIII => 'XIII',
        };
    }

    //This will return the array with key value pair; to be used in Select inputs
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($branch) => [
            $branch->value => $branch->label(),
        ])->toArray();
    }
}
