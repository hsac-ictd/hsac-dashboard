<?php

namespace App\Filament\Clusters\Cases\Resources;

use App\Filament\Clusters\Cases;
use App\Filament\Clusters\Cases\Resources\AppealedCaseResource\Pages;
use App\Filament\Clusters\Cases\Resources\AppealedCaseResource\RelationManagers;
use App\Models\AppealedCase;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppealedCaseResource extends Resource
{
    protected static ?string $model = AppealedCase::class;
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $pluralModelLabel = "Appealed Cases";
    protected static ?string $navigationLabel = "Appealed";
    protected static ?string $modelLabel = "Appealed Case";
    protected static ?string $cluster = Cases::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Status')
                    ->validationAttribute('status')
                    ->native(false)
                    ->options(\App\Enum\CaseStatus::options())
                    ->required(),
                Select::make('case_type')
                    ->label('Case Type')
                    ->validationAttribute('case type')
                    ->native(false)
                    ->options(\App\Enum\CaseType::optionsForAppealedCases())
                    ->required(),
                TextInput::make('total')
                    ->label('Total Cases')
                    ->validationAttribute('total cases')
                    ->suffix('For the chosen month and year')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                DatePicker::make('month_year')
                    ->label('Month & Year')
                    ->validationAttribute('month and year')
                    ->native(false)
                    ->displayFormat('F Y')
                    ->maxDate(now())
                    ->suffixIcon('heroicon-o-calendar')
                    ->hint('Choose the 1st day of the month.')
                    ->closeOnDateSelection()
                    ->required()
                    ->afterStateUpdated(function ($state, Set $set) {
                        //Always set the month_year to the start of the month
                        if ($state) {
                            $set('month_year', \Illuminate\Support\Carbon::parse($state)->startOfMonth());
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state): string => \App\Enum\CaseStatus::from($state)->icon())
                    ->color(fn (string $state): string => \App\Enum\CaseStatus::from($state)->color())
                    ->searchable(),
                TextColumn::make('case_type')
                    ->label('Case Type')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total Cases')
                    ->sortable(),
                TextColumn::make('month_year')
                    ->label('Month & Year')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->format('F Y')),
            ])
            ->groups([
                Group::make('status')
                    ->label('Status'),
                Group::make('case_type')
                    ->label('Case Type'),
                Group::make('month_year')
                    ->label('Month & Year'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(\App\Enum\CaseStatus::options()),
            ], layout: Tables\Enums\FiltersLayout::Modal)
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->filtersFormColumns(1)
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
            'index' => Pages\ListAppealedCases::route('/'),
            'create' => Pages\CreateAppealedCase::route('/create'),
            'edit' => Pages\EditAppealedCase::route('/{record}/edit'),
        ];
    }
}
