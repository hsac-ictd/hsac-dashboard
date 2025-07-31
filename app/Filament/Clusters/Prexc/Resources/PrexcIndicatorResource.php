<?php

namespace App\Filament\Clusters\Prexc\Resources;

use App\Enum\CaseStatus;
use App\Filament\Clusters\Prexc;
use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\Pages;
use App\Filament\Clusters\Prexc\Resources\PrexcIndicatorResource\RelationManagers;
use App\Models\AppealedCase;
use App\Models\CaseTimelinessMetric;
use App\Models\MonthlyCaseWorkload;
use App\Models\PrexcIndicator;
use App\Models\RabCase;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
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
                    ->afterStateUpdated(function ($state, callable $get, Set $set) {
                        $set('year', null);
                        $set('target', null);
                        $set('accomplishment', null);
                        $set('percentage_of_accomplishment', null);

                        if (!$state) {
                            return;
                        }

                        $indicator = \App\Enum\Indicator::tryFrom($state);

                        if ($indicator) {
                            $set('description', $indicator->description());
                        }
                    }),
                Textarea::make('description')
                    ->label('Description')
                    ->validationAttribute('description')
                    ->required()
                    ->readOnly()
                    ->autosize(),
                Forms\Components\Group::make([
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
                        ->hintIcon('heroicon-o-question-mark-circle', 'Auto-compute based on the chosen year and indicator')
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
                        ->hintIcon('heroicon-o-question-mark-circle', 'Auto-compute based on the target and accomplishment values')
                        ->validationAttribute('accomplishment')
                        ->numeric()
                        ->inputMode('decimal')
                        ->suffixIcon('heroicon-m-percent-badge')
                        ->required()
                        ->readOnly(),
                ])
                ->columns(4)
                ->columnSpanFull(),
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
                    ->sortable()
                    ->description(fn (PrexcIndicator $record): string => $record->description)
                    ->wrap(),
                TextColumn::make('target')
                    ->label('Target')
                    ->suffix('%'),
                TextColumn::make('accomplishment')
                    ->label('Accomplishment')
                    ->suffix('%'),
                TextColumn::make('percentage_of_accomplishment')
                    ->label('% of Accomplishment')
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->color(function (PrexcIndicator $record) {
                        if (is_null($record->accomplishment) || is_null($record->target)) {
                            return 'default';
                        }

                        return $record->accomplishment >= $record->target ? 'green' : 'red';
                    })
                    ->prefix(function (PrexcIndicator $record) {
                        if (is_null($record->accomplishment) || is_null($record->target)) {
                            return null;
                        }

                        return $record->accomplishment >= $record->target ? '👍🏼 ' : '👎🏼 ';
                    })
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
            ->defaultSort('created_at', 'desc')
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
        //For the Client Satisfaction indicator
        else if ($indicator === \App\Enum\Indicator::CLIENT_SATISFACTION->value) {
            $totalResolvedRAB = RabCase::where('status', CaseStatus::Resolved->value)->whereYear('month_year', now()->year)->sum('total');

            $totalFiledAppealed = AppealedCase::where('status', CaseStatus::Filed->value)->whereYear('month_year', now()->year)->sum('total');

            $clientSatisfactionRate = null;

            if ($totalResolvedRAB && $totalFiledAppealed && $totalResolvedRAB > 0) {
                //“This metric assumes that cases not escalated to appeal imply satisfactory resolution at the regional level.”
                $clientSatisfactionRate = round((($totalResolvedRAB - $totalFiledAppealed) / $totalResolvedRAB) * 100, 2);
                $set('accomplishment', $clientSatisfactionRate);
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
