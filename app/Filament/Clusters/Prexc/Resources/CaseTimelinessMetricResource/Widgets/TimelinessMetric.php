<?php

namespace App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Widgets;

use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages\ListCaseTimelinessMetrics;
use App\Models\CaseTimelinessMetric;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TimelinessMetric extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListCaseTimelinessMetrics::class;
    }
    protected function getStats(): array
    {
        $rateREM = '';
        $rateHOA = '';
        $rateAppealed = '';

        //Get the total number of disposed and ripe cases
        $disposedREM = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::REM->value)
                        ->whereYear('month_year', now()->year)
                        ->sum('total_disposed');
        //Get the latest total_ripe as of today
        $latestRipeREM = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::REM->value)
                        ->orderByDesc('month_year')
                        ->value('total_ripe');
        //Sum up the disposed and the latestRipe
        $totalREM = $disposedREM + $latestRipeREM;

        //Formula is (total disposed/(total disposed + latest total ripe))*100
        if ($totalREM && $totalREM > 0) {
            $rateREM = round(($disposedREM / $totalREM) * 100, 2);
        }

        //Get the total number of disposed and ripe cases
        $disposedHOA = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::HOA->value)
                        ->whereYear('month_year', now()->year)
                        ->sum('total_disposed');
        //Get the latest total_ripe as of today
        $latestRipeHOA = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::HOA->value)
                        ->orderByDesc('month_year')
                        ->value('total_ripe');
        //Sum up the disposed and the latestRipe
        $totalHOA = $disposedHOA + $latestRipeHOA;

        //Formula is (total disposed/(total disposed + latest total ripe))*100
        if ($totalHOA && $totalHOA > 0) {
            $rateHOA = round(($disposedHOA / $totalHOA) * 100, 2);
        }

        //Get the total number of disposed and ripe cases
        $disposedAppealed = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::Appealed->value)
                        ->whereYear('month_year', now()->year)
                        ->sum('total_disposed');
        //Get the latest total_ripe as of today
        $latestRipeAppealed = CaseTimelinessMetric::where('case_type', \App\Enum\CaseType::Appealed->value)
                        ->orderByDesc('month_year')
                        ->value('total_ripe');
        //Sum up the disposed and the latestRipe
        $totalAppealed = $disposedAppealed + $latestRipeAppealed;

        //Formula is (total disposed/(total disposed + latest total ripe))*100
        if ($totalAppealed && $totalAppealed > 0) {
            $rateAppealed = round(($disposedAppealed / $totalAppealed) * 100, 2);
        }

        return [
            Stat::make('Timeliness Rate (REM)', $rateREM . '%')
                ->description(now()->year . ' • Disposed / (Disposed + Ripe)')
                ->descriptionColor('info')
                ->color('info'),
            Stat::make('Timeliness Rate (HOA)', $rateHOA . '%')
                ->description(now()->year . ' • Disposed / (Disposed + Ripe)')
                ->descriptionColor('info')
                ->color('info'),
            Stat::make('Timeliness Rate (Appealed)', $rateAppealed . '%')
                ->description(now()->year . ' • Disposed / (Disposed + Ripe)')
                ->descriptionColor('info')
                ->color('info'),
        ];
    }
}
