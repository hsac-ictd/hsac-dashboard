<?php

namespace App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Widgets;

use App\Enum\CaseStatus;
use App\Enum\CaseType;
use App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages\ListAppealedCases;
use App\Models\AppealedCase;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalAppealedCases extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListAppealedCases::class;
    }
    
    protected function getStats(): array
    {
        $monthlyDataFiled = AppealedCase::selectRaw('MONTH(month_year) as month, SUM(total) as total')
            ->where('status', CaseStatus::Filed->value) // You can use your Enum if needed
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $chartDataFiled = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartDataFiled[] = $monthlyDataFiled[$i] ?? 0; // default to 0 if no data for that month
            }

        $monthlyDataResolved = AppealedCase::selectRaw('MONTH(month_year) as month, SUM(total) as total')
            ->where('status', CaseStatus::Resolved->value) // You can use your Enum if needed
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $chartDataResolved = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartDataResolved[] = $monthlyDataResolved[$i] ?? 0; // default to 0 if no data for that month
            }

        return [
            Stat::make('Filed Appealed Cases', AppealedCase::where('status', CaseStatus::Filed->value)->whereYear('month_year', now()->year)->sum('total'))
                ->description('As of this year')
                ->descriptionColor('info')
                ->chart($chartDataFiled)
                ->color('info'),
            Stat::make('Resolved Appealed Cases', AppealedCase::where('status', CaseStatus::Resolved->value)->whereYear('month_year', now()->year)->sum('total'))
                ->description('As of this year')
                ->descriptionColor('success')
                ->chart($chartDataResolved)
                ->color('success'),
        ];
    }
}
