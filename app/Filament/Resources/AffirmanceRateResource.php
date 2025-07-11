<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffirmanceRateResource\Pages;
use App\Filament\Resources\AffirmanceRateResource\RelationManagers;
use App\Models\AffirmanceRate;
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

class AffirmanceRateResource extends Resource
{
    protected static ?string $model = AffirmanceRate::class;
    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $pluralModelLabel = "Affirmance Data";
    protected static ?string $modelLabel = "Affirmance Data";
    protected static ?string $navigationLabel = "Affirmance";
    protected static ?string $navigationGroup = 'Data Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('court')
                    ->label('Court')
                    ->validationAttribute('court')
                    ->native(false)
                    ->options(\App\Enum\Court::options())
                    ->required(),
                Select::make('outcome')
                    ->label('Outcome')
                    ->validationAttribute('outcome')
                    ->native(false)
                    ->searchable()
                    ->options(\App\Enum\LegalOutcome::options())
                    ->required(),
                TextInput::make('total')
                    ->label('Total Decisions')
                    ->validationAttribute('total decisions')
                    ->numeric()
                    ->minValue(1)
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
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('court')
                    ->label('Court')
                    ->searchable(),
                TextColumn::make('outcome')
                    ->label('Outcome')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Affirmed' => 'green',
                        'Reversed' => 'red'
                    })
                    ->searchable(),
                TextColumn::make('total')
                    ->label('Total Decisions')
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
            'index' => Pages\ListAffirmanceRates::route('/'),
            'create' => Pages\CreateAffirmanceRate::route('/create'),
            'edit' => Pages\EditAffirmanceRate::route('/{record}/edit'),
        ];
    }
}
