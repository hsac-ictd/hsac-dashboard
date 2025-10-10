<?php

namespace App\Http\Controllers;

use App\Models\IndigentLitigant;
use App\Models\PrexcIndicator;
use App\Models\AffirmanceRate;
use App\Models\RabCase;
use App\Models\AppealedCase;


use App\Enum\Indicator;
use App\Enum\Branch;
use App\Enum\CaseType;
use App\Enum\CaseStatus;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. PrexcIndicators logic (unchanged)
        $allIndicators = collect(Indicator::cases())->map(fn ($case) => $case->value);
        $storedData = PrexcIndicator::all()->keyBy('indicator');

        $prexcIndicators = $allIndicators->map(function ($indicatorValue) use ($storedData) {
            if ($storedData->has($indicatorValue)) {
                $record = $storedData->get($indicatorValue);
                return [
                    'description' => $record->description,
                    'indicator' => $record->indicator,
                    'target' => $record->target,
                    'accomplishment' => $record->accomplishment,
                    'percentage_of_accomplishment' => $record->percentage_of_accomplishment,
                    'year' => $record->year,
                    'id' => $record->id,
                ];
            } else {
                return [
                     'description' => 'No description',
                    'indicator' => $indicatorValue,
                    'target' => null,
                    'accomplishment' => null,
                    'percentage_of_accomplishment' => null,
                    'year' => null,
                    'id' => null,
                ];
            }
        })->values();

        // 2. AffirmanceRate (latest month for Court of Appeals)
       $currentYear = Carbon::now()->year;

        $appealsAffirmanceData = AffirmanceRate::select('outcome')
            ->where('court', 'Court of Appeals')
            ->whereYear('month_year', $currentYear)
            ->groupBy('outcome')
            ->selectRaw('SUM(total) as total')
            ->get()
            ->map(function ($item) {
                return [
                    'outcome' => $item->outcome,
                    'total' => (int) $item->total,
                ];
            })
            ->toArray();

        $appealsAffirmanceMonth = (string) $currentYear;


        // 3. AffirmanceRate (latest month for Supreme Court)
      $currentYear = Carbon::now()->year;

$courtAffirmanceData = AffirmanceRate::select('outcome')
    ->where('court', 'Supreme Court')
    ->whereYear('month_year', $currentYear)
    ->groupBy('outcome')
    ->selectRaw('SUM(total) as total')
    ->get()
    ->map(function ($item) {
        return [
            'outcome' => $item->outcome,
            'total' => (int) $item->total,
        ];
    })
    ->toArray();

$courtAffirmanceMonth = (string) $currentYear;


            // 4. RabCases logic
        //    $currentYear = now()->year;

        //     $dbTotals = RabCase::select('rab', DB::raw('SUM(total) as total'))
        //     ->whereYear('month_year', $currentYear)
        //     ->whereRaw('TRIM(LOWER(status)) = ?', [strtolower(CaseStatus::Filed->value)])
        //     ->groupBy('rab')
        //     ->pluck('total', 'rab');


        //     // Map to full list of branches with counts
        //     $rabCases = collect(Branch::cases())->map(function ($branch) use ($dbTotals) {
        //         return [
        //             'region' => $branch->value,
        //             'value' => (int) ($dbTotals[$branch->value] ?? 0), // default 0 if none
        //         ];
        //     })->values();

    // 5. RabCaseType logic
   $currentYear = now()->startOfYear();

    $rabCaseTypeStats = RabCase::select([
            'case_type',
            DB::raw("SUM(CASE WHEN status = 'Filed' THEN total ELSE 0 END) as newCasesFiled"),
            DB::raw("SUM(CASE WHEN status = 'Resolved' THEN total ELSE 0 END) as disposed")
        ])
        ->where('month_year', '>=', $currentYear)
        ->groupBy('case_type')
        ->get()
        ->map(function ($row) {
            return [
                'name' => CaseType::tryFrom($row->case_type)?->label() ?? $row->case_type, // fallback if invalid
                'newCasesFiled' => (int) $row->newCasesFiled,
                'disposed' => (int) $row->disposed,
            ];
        });

        // 6. AppealedCaseType logic
         $appealCaseTypeData = AppealedCase::query()
        ->whereYear('month_year', now()->year)
        ->get()
        ->groupBy('case_type')
        ->map(function ($groupedCases, $caseType) {
            return [
                'name' => $caseType,
                'newCasesFiled' => $groupedCases->where('status', 'Filed')->sum('total'),
                'disposed' => $groupedCases->where('status', 'Resolved')->sum('total'),
            ];
        })
        ->values();

        // 7. Yearly statistics for RAB Cases
          $yearlyResolved = RabCase::select(
        DB::raw('YEAR(month_year) as year'),
        DB::raw('SUM(total) as disposed')
    )
    ->where('status', 'Resolved')
    ->groupBy(DB::raw('YEAR(month_year)'))
    ->orderBy('year')
    ->get()
    ->map(fn ($item) => [
        'year' => (string) $item->year,
        'disposed' => (int) $item->disposed,
    ]);

    
// 8. Yearly statistics for Appealed Cases resolved count by year
$yearlyResolvedAppealed = AppealedCase::select(
    DB::raw('YEAR(month_year) as year'),
    DB::raw('SUM(total) as disposed')
)
->where('status', 'Resolved')
->groupBy(DB::raw('YEAR(month_year)'))
->orderBy('year')
->get()
->map(fn ($item) => [
    'year' => (string) $item->year,
    'disposed' => (int) $item->disposed,
]);


// 9.Total RAB Cases Filed this year
$currentYear = now()->year;


$dbTotals = RabCase::select('rab', DB::raw('SUM(total) as total'))
    ->whereYear('month_year', $currentYear)
    ->where('status', 'Filed') 
    ->groupBy('rab')
    ->pluck('total', 'rab');


$rabCases = collect(Branch::cases())->map(function ($branch) use ($dbTotals) {
    return [
        'region' =>  $branch->value, 
        'value' => (int) ($dbTotals[$branch->value] ?? 0),
    ];
})->values();

// 10.Total RAB Cases Filed this year
$totalRabCasesFiled = RabCase::whereYear('month_year', $currentYear)
    ->where('status', 'Filed')
    ->sum('total');

// 11.Total RAB Cases Resolved this year
$totalRabCasesResolved = RabCase::whereYear('month_year', $currentYear)
    ->where('status', 'Resolved')
    ->sum('total');   

// 12. Total Appealed Cases Filed this year
$totalAppealCasesFiled = AppealedCase::whereYear('month_year', $currentYear)
    ->where('status', 'Filed')
    ->sum('total');

// 13. Total Appealed Cases Resolved this year    
$totalAppealCasesResolved = AppealedCase::whereYear('month_year', $currentYear)
    ->where('status', 'Resolved')
    ->sum('total');

    // 14. Total Indigent Litigants this year
$currentYear = now()->startOfYear();

$totalIndigentLitigants = IndigentLitigant::where('month_year', '>=', $currentYear)
    ->sum('total_indigents');

    // 15. Total Certificates of Indigency submitted this year
$totalCertificatesSubmitted = IndigentLitigant::where('month_year', '>=', $currentYear)
    ->sum('with_certificate');

    


        // Return Inertia view with all data
        return Inertia::render('dashboard', [
            'prexcIndicators' => $prexcIndicators,
            'appealsAffirmance' => [
                'data' => $appealsAffirmanceData,
                'month' => $appealsAffirmanceMonth,
            ],
            'courtAffirmanceData' => $courtAffirmanceData,
            'courtAffirmanceMonth' => $courtAffirmanceMonth,
            'rabCasesData' => $rabCases,
            'rabCaseTypeData' => $rabCaseTypeStats,
            'appealCaseTypeData' => $appealCaseTypeData,
            'yearlyDisposedCases' => $yearlyResolved,
            'yearlyAppealDisposedCases' => $yearlyResolvedAppealed,
             'totalRabCasesFiled' => $totalRabCasesFiled,
             'totalRabCasesResolved' => $totalRabCasesResolved,
             'totalAppealCasesFiled' => $totalAppealCasesFiled,
             'totalAppealCasesResolved' => $totalAppealCasesResolved,
             'totalIndigentLitigants' => $totalIndigentLitigants,
             'totalCertificatesSubmitted' => $totalCertificatesSubmitted,
        ]);
    }
}
