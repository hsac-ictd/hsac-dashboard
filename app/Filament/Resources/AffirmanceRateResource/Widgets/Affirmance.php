<?php

namespace App\Filament\Resources\AffirmanceRateResource\Widgets;

use App\Enum\Court;
use App\Enum\LegalOutcome;
use App\Filament\Resources\AffirmanceRateResource\Pages\ListAffirmanceRates;
use App\Models\AffirmanceRate;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Affirmance extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListAffirmanceRates::class;
    }
    protected function getStats(): array
    {
        $affirmanceRateCA = '';
        $affirmanceRateSC = '';

        $affirmedCA = AffirmanceRate::where('court', Court::CA->value)->where('outcome', LegalOutcome::AFFIRMED->value)->whereYear('month_year', now()->year)->sum('total');
        $reversedCA = AffirmanceRate::where('court', Court::CA->value)->where('outcome', LegalOutcome::REVERSED->value)->whereYear('month_year', now()->year)->sum('total');

        $totalCA = $affirmedCA + $reversedCA;

        if ($totalCA && $totalCA > 0) {
            $affirmanceRateCA = round(($affirmedCA / $totalCA) * 100, 2);
        }

        $affirmedSC = AffirmanceRate::where('court', Court::SC->value)->where('outcome', LegalOutcome::AFFIRMED->value)->whereYear('month_year', now()->year)->sum('total');
        $reversedSC = AffirmanceRate::where('court', Court::SC->value)->where('outcome', LegalOutcome::REVERSED->value)->whereYear('month_year', now()->year)->sum('total');

        $totalSC = $affirmedSC + $reversedSC;

        if ($totalSC && $totalSC > 0) {
            $affirmanceRateSC = round(($affirmedSC / $totalSC) * 100, 2);
        }

        return [
            Stat::make('✅ Affirmance Rate (Court of Appeals)', $affirmanceRateCA . '%')
                ->description(now()->year . ' • Affirmed / (Affirmed + Reversed)')
                ->descriptionColor('info')
                ->color('info'),
            Stat::make('✅ Affirmance Rate (Supreme Court)', $affirmanceRateSC . '%')
                ->description(now()->year . ' • Affirmed / (Affirmed + Reversed)')
                ->descriptionColor('info')
                ->color('info'),
        ];
    }
}
