<?php

namespace App\Filament\Clusters\Cases\Resources\RabCaseResource\Widgets;

use App\Enum\CaseStatus;
use App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages\ListRabCases;
use App\Models\AppealedCase;
use App\Models\RabCase;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRabCases extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListRabCases::class;
    }

    protected function getStats(): array
    {
        $monthlyDataFiled = RabCase::selectRaw('MONTH(month_year) as month, SUM(total) as total')
            ->where('status', CaseStatus::Filed->value) // You can use your Enum if needed
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $chartDataFiled = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataFiled[] = $monthlyDataFiled[$i] ?? 0; // default to 0 if no data for that month
        }

        $monthlyDataResolved = RabCase::selectRaw('MONTH(month_year) as month, SUM(total) as total')
            ->where('status', CaseStatus::Resolved->value) // You can use your Enum if needed
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $chartDataResolved = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataResolved[] = $monthlyDataResolved[$i] ?? 0; // default to 0 if no data for that month
        }

        $totalFiledRab = RabCase::where('status', CaseStatus::Filed->value)->whereYear('month_year', now()->year)->sum('total');
        $totalResolvedRAB = RabCase::where('status', CaseStatus::Resolved->value)->whereYear('month_year', now()->year)->sum('total');
        $totalFiledAppealed = AppealedCase::where('status', CaseStatus::Filed->value)->whereYear('month_year', now()->year)->sum('total');

        // Calculate client satisfaction rate 
        $clientSatisfactionRate = null;
        if ($totalResolvedRAB && $totalFiledAppealed && $totalResolvedRAB > 0) {
            $clientSatisfactionRate = round((($totalResolvedRAB - $totalFiledAppealed) / $totalResolvedRAB) * 100, 2);
        }

        return [
            Stat::make('📂 Filed RAB Cases', $totalFiledRab)
                ->description('As of this year')
                ->descriptionColor('info')
                ->chart($chartDataFiled)
                ->color('info'),
            Stat::make('✅ Resolved RAB Cases', $totalResolvedRAB)
                ->description('As of this year')
                ->descriptionColor('success')
                ->chart($chartDataResolved)
                ->color('success'),
            Stat::make('🌟 Client Satisfaction Rate', $clientSatisfactionRate . '%')
                ->description(now()->year . ' • (Resolved RAB Cases - Filed Appealed Cases) / Resolved RAB Cases')
                ->descriptionColor('yellow')
                ->color('yellow'),
        ];
    }
}
