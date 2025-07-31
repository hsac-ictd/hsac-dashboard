<?php

namespace App\Filament\Resources\IndigentLitigantResource\Widgets;

use App\Filament\Resources\IndigentLitigantResource\Pages\ListIndigentLitigants;
use App\Models\IndigentLitigant;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Indigents extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListIndigentLitigants::class;
    }

    protected function getStats(): array
    {
        $monthlyDataIndigents = IndigentLitigant::selectRaw('MONTH(month_year) as month, SUM(total_indigents) as total_indigents')
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_indigents', 'month');

        $chartDataIndigents = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartDataIndigents[] = $monthlyDataIndigents[$i] ?? 0; // default to 0 if no data for that month
            }

        $monthlyDataWithCert = IndigentLitigant::selectRaw('MONTH(month_year) as month, SUM(with_certificate) as with_certificate')
            ->whereYear('month_year', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('with_certificate', 'month');

        $chartDataWithCert = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartDataWithCert[] = $monthlyDataWithCert[$i] ?? 0; // default to 0 if no data for that month
            }

        return [
            Stat::make('🧍🏽 Number of Indigent Litigants', IndigentLitigant::whereYear('month_year', now()->year)->sum('total_indigents'))
                ->description('As of this year')
                ->descriptionColor('info')
                ->chart($chartDataIndigents)
                ->color('info'),
            Stat::make('📨 Certificate of Indigency Submitted', IndigentLitigant::whereYear('month_year', now()->year)->sum('with_certificate'))
                ->description('As of this year')
                ->descriptionColor('success')
                ->chart($chartDataWithCert)
                ->color('success'),
        ];
    }
}
