<?php

namespace App\Filament\Clusters\Cases\Resources;

use App\Filament\Clusters\Cases;
use App\Filament\Clusters\Cases\Resources\RabCaseResource\Pages;
use App\Filament\Clusters\Cases\Resources\RabCaseResource\RelationManagers;
use App\Models\RabCase;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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

class RabCaseResource extends Resource
{
    protected static ?string $model = RabCase::class;
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $pluralModelLabel = "RAB Cases";
    protected static ?string $navigationLabel = "RAB";
    protected static ?string $modelLabel = "RAB Case";
    protected static ?string $cluster = Cases::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('rab')
                    ->label('Regional Adjudication Branch')
                    ->validationAttribute('regional adjudication branch')
                    ->native(false)
                    ->options(\App\Enum\Branch::options())
                    ->required(),
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
                    ->options(\App\Enum\CaseType::optionsForRabCases())
                    ->required(),
                TextInput::make('total')
                    ->label('Total Cases')
                    ->validationAttribute('total cases')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                DatePicker::make('month_year')
                    ->label('Month & Year')
                    ->validationAttribute('month and year')
                    ->native(false)
                    ->displayFormat('F Y')
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
                TextColumn::make('rab')
                    ->label('RAB')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Filed' => 'warning',
                        'Resolved' => 'green',
                    })
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
            'index' => Pages\ListRabCases::route('/'),
            'create' => Pages\CreateRabCase::route('/create'),
            'edit' => Pages\EditRabCase::route('/{record}/edit'),
        ];
    }
}
