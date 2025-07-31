<?php

namespace App\Enum;

enum Indicator: string
{
    //Internal name with a value that will be stored in DB or used as a display key
    case PTDHC = 'Percentage of Total Number of Disposed Cases / Total Handled Cases'; 
    case TIMELINESS_REM = 'Timeliness (REM)';
    case TIMELINESS_HOA = 'Timeliness (HOA)';
    case TIMELINESS_APPEALED = 'Timeliness of Appealed Cases';
    case CLIENT_SATISFACTION = 'Client Satisfaction';

    //The label can be changed here for the options; but the value to be used to store in DB is the case (up there) 👆
    public function label(): string
    {
        return match ($this) {
            self::PTDHC => 'Percentage of Total Number of Disposed Cases / Total Handled Cases',
            self::TIMELINESS_REM => 'Timeliness (REM)',
            self::TIMELINESS_HOA => 'Timeliness (HOA)',
            self::TIMELINESS_APPEALED => 'Timeliness of Appealed Cases',
            self::CLIENT_SATISFACTION => 'Client Satisfaction',
        };
    }

    //This will return the array with key value pair; to be used in Select inputs
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($indicator) => [
            $indicator->value => $indicator->label(),
        ])->toArray();
    }

    public function description(): string
    {
        return match ($this) {
            self::PTDHC => 'Percentage of decisions rendered out of the total number of cases ',
            self::TIMELINESS_REM => 'Percentage of decisions rendered on real estate management within ninety (90) calendar days out of the total number of cases deemed submitted for decision',
            self::TIMELINESS_HOA => 'Percentage of decisions rendered on HOA disputes within ninety (90) calendar days out of the total number of cases deemed submitted for decision',
            self::TIMELINESS_APPEALED => 'Percentage of appealed cases resolved by the Commission within the prescribed period of 120 days from the date the appeal is deemed submitted for decision',
            self::CLIENT_SATISFACTION => 'Percentage of stakeholders who rated the adjudication processes as satisfactory or better',
        };
    }
}
