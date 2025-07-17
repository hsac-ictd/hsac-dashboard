<?php

namespace App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Widgets;

use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Pages\ListMonthlyCaseWorkloads;
use App\Models\MonthlyCaseWorkload;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CaseWorkload extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListMonthlyCaseWorkloads::class;
    }
    protected function getStats(): array
    {
        $rate = '';
        
        //Get the total number of handled and disposed cases
        $disposed =  MonthlyCaseWorkload::whereYear('month_year', now()->year)
                        ->sum('total_disposed');

        //Get the latest total_handled as of today
        $latestHandled = MonthlyCaseWorkload::orderByDesc('month_year')
                            ->value('total_handled');
    
        //Sum up total disposed and the latest handled 
        $total = $disposed + $latestHandled;

        //Formula is (total disposed/(total disposed + latest total handled))*100
        if ($total && $total > 0) {
            $rate = round(($disposed / $total) * 100, 2);
        }

        return [
            Stat::make('Disposition Rate', $rate . '%')
                ->description(now()->year . ' • Disposed / (Disposed + Handled)')
                ->descriptionColor('info')
                ->color('info'),
        ];
    }
}
