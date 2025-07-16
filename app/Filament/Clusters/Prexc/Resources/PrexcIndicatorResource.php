<?php

namespace App\Filament\Clusters\Prexc\Resources;

use App\Filament\Clusters\Prexc;
use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\Pages;
use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\RelationManagers;
use App\Models\CaseTimelinessMetric;
use App\Models\MonthlyCaseWorkload;
use App\Models\PrexcIndicator;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrexcIndicatorResource extends Resource
{
    protected static ?string $model = PrexcIndicator::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $pluralModelLabel = "Program Expenditure Classification Data";
    protected static ?string $navigationLabel = "Target vs Accomplishment";
    protected static ?string $modelLabel = "Program Expenditure Classification Data";
    protected static ?string $cluster = Prexc::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('indicator')
                    ->label('Indicator')
                    ->validationAttribute('indicator')
                    ->native(false)
                    ->options(\App\Enum\Indicator::options())
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('year', null);
                        $set('target', null);
                        $set('accomplishment', null);
                        $set('percentage_of_accomplishment', null);
                    }),
                Select::make('year')
                    ->label('Year')
                    ->validationAttribute('year')
                    ->native(false)
                    ->options(fn () => collect(range(now()->year, 2019))->mapWithKeys(fn ($y) => [$y => $y]))        
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, Set $set) {
                        if (!$state) {
                            $set('indicator', null);
                            $set('target', null);
                            $set('accomplishment', null);
                            $set('percentage_of_accomplishment', null);
                        }
                        if ($state) {
                            static::computeAccomplishment($get, $set);
                        }
                    }),
                TextInput::make('target')
                    ->label('Target')
                    ->validationAttribute('target')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-m-percent-badge')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, Set $set) {
                        if ($state) {
                            static::computePercentageOfAccomplishment($get, $set);
                        }
                    }),
                TextInput::make('accomplishment')
                    ->label('Accomplishment')
                    ->hint('Auto-compute based on the chosen year and indicator')
                    ->validationAttribute('accomplishment')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-m-percent-badge')
                    ->required()
                    ->readOnly()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, Set $set) {
                        if ($state) {
                            static::computePercentageOfAccomplishment($get, $set);
                        }
                    }),
                TextInput::make('percentage_of_accomplishment')
                    ->label('Percentage of Accomplishment')
                    ->hint('Auto-compute based on the target and accomplishment values')
                    ->validationAttribute('accomplishment')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-m-percent-badge')
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('indicator')
                    ->label('Indicator')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('target')
                    ->label('Target')
                    ->suffix('%'),
                TextColumn::make('accomplishment')
                    ->label('Accomplishment')
                    ->suffix('%'),
                TextColumn::make('percentage_of_accomplishment')
                    ->label('Percentage of Accomplishment')
                    ->suffix('%'),
                TextColumn::make('year')
                    ->label('Year')
                    ->searchable()
                    ->sortable(),
            ])
            ->groups([
                Group::make('year')
                    ->label('Year'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrexcIndicators::route('/'),
            'create' => Pages\CreatePrexcIndicator::route('/create'),
            'edit' => Pages\EditPrexcIndicator::route('/{record}/edit'),
        ];
    }

    public static function computeAccomplishment(callable $get, Set $set): void 
    {
        $year = $get('year');
        $indicator = $get('indicator');
        $caseType = null;

        //For the Percentage of total disposed over total handled indicator
        if ($indicator === \App\Enum\Indicator::PTDHC->value && $year) {
            //Get the total number of handled and disposed cases
            $disposed =  MonthlyCaseWorkload::whereYear('month_year', $year)
                            ->sum('total_disposed');

            //Get the latest total_handled as of today
            $latestHandled = MonthlyCaseWorkload::orderByDesc('month_year')
                                ->value('total_handled');
        
            //Sum up total disposed and the latest handled 
            $total = $disposed + $latestHandled;

            //Formula is (total disposed/(total disposed + latest total handled))*100
            if ($total && $total > 0) {
                $rate = round(($disposed / $total) * 100, 2);
                $set('accomplishment', $rate);
            } else {
                $set('accomplishment', null);
            }
        } 
        //For the Timeliness indicators
        else if (
            in_array(
                $indicator,
                [
                    \App\Enum\Indicator::TIMELINESS_REM->value,
                    \App\Enum\Indicator::TIMELINESS_HOA->value,
                    \App\Enum\Indicator::TIMELINESS_APPEALED->value
                ]
            ) && $year
        ) {
            switch ($indicator) {
                case \App\Enum\Indicator::TIMELINESS_REM->value:
                    $caseType = \App\Enum\CaseType::REM->value;
                    break;
                case \App\Enum\Indicator::TIMELINESS_HOA->value:
                    $caseType = \App\Enum\CaseType::HOA->value;
                    break;
                case \App\Enum\Indicator::TIMELINESS_APPEALED->value:
                    $caseType = \App\Enum\CaseType::Appealed->value;
                    break;
            }

            //Get the total number of disposed and ripe cases
            $disposed = CaseTimelinessMetric::where('case_type', $caseType)
                            ->whereYear('month_year', $year)
                            ->sum('total_disposed');
            //Get the latest total_ripe as of today
            $latestRipe = CaseTimelinessMetric::where('case_type', $caseType)
                            ->orderByDesc('month_year')
                            ->value('total_ripe');
            //Sum up the disposed and the latestRipe
            $total = $disposed + $latestRipe;

            //Formula is (total disposed/(total disposed + latest total ripe))*100
            if ($total && $total > 0) {
                $rate = round(($disposed / $total) * 100, 2);
                $set('accomplishment', $rate);
            } else {
                $set('accomplishment', null);
            }
        } 
    }

    public static function computePercentageOfAccomplishment(callable $get, Set $set): void 
    {
        $target = $get('target');
        $accomplishment = $get('accomplishment');

        if ($target && $accomplishment && $target > 0) {
            $rate = round(($accomplishment / $target) * 100, 2);
            $set('percentage_of_accomplishment', $rate);
        } else {
            $set('percentage_of_accomplishment', null);
        }
    }
}
