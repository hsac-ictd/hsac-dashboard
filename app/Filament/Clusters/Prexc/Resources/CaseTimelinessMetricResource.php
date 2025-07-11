<?php

namespace App\Filament\Clusters\Prexc\Resources;

use App\Filament\Clusters\Prexc;
use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\Pages;
use App\Filament\Clusters\Prexc\Resources\CaseTimelinessMetricResource\RelationManagers;
use App\Models\CaseTimelinessMetric;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaseTimelinessMetricResource extends Resource
{
    protected static ?string $model = CaseTimelinessMetric::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $pluralModelLabel = "Timeliness Metric Data";
    protected static ?string $modelLabel = "Timeliness Metric Data";
    protected static ?string $navigationLabel = "Timeliness Metric";
    protected static ?string $cluster = Prexc::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('case_type')
                    ->label('Type of Case')
                    ->validationAttribute('type of case')
                    ->native(false)
                    ->options(\App\Enum\CaseType::optionsForTimeliness())
                    ->required(),
                DatePicker::make('month_year')
                    ->label('Month & Year')
                    ->validationAttribute('month and year')
                    ->native(false)
                    ->displayFormat('F Y')
                    ->hint('Choose the 1st day of the month.')
                    ->closeOnDateSelection()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        //Always set the month_year to the start of the month
                        if ($state) {
                            $set('month_year', \Illuminate\Support\Carbon::parse($state)->startOfMonth());
                            $set('year', \Illuminate\Support\Carbon::parse($state)->startOfMonth()->year);
                        }
                    }),
                TextInput::make('total_disposed')
                    ->label('Total Disposed Cases')
                    ->validationAttribute('total disposed cases')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                TextInput::make('total_ripe')
                    ->label('Total Ripe for Resolution Cases')
                    ->validationAttribute('total ripe for resolution cases')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Hidden::make('year')
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case_type')
                    ->label('Case Type')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_disposed')
                    ->label('Total Disposed'),
                TextColumn::make('total_ripe')
                    ->label('Total Ripe for Resolution'),
                TextColumn::make('month_year')
                    ->label('Month & Year')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->format('F Y')),
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
            'index' => Pages\ListCaseTimelinessMetrics::route('/'),
            'create' => Pages\CreateCaseTimelinessMetric::route('/create'),
            'edit' => Pages\EditCaseTimelinessMetric::route('/{record}/edit'),
        ];
    }
}
