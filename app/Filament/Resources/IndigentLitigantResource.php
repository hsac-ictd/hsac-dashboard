<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndigentLitigantResource\Pages;
use App\Filament\Resources\IndigentLitigantResource\RelationManagers;
use App\Models\IndigentLitigant;
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

class IndigentLitigantResource extends Resource
{
    protected static ?string $model = IndigentLitigant::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralModelLabel = "Indigents Data";
    protected static ?string $modelLabel = "Indigents Data";
    protected static ?string $navigationLabel = "Indigents";
    protected static ?string $navigationGroup = 'Data Management';

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
                TextInput::make('total_indigents')
                    ->label('Number of Indigent Litigants')
                    ->validationAttribute('number of indigents')
                    ->suffixIcon('heroicon-o-user-group')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('with_certificate')
                    ->label('Submitted Certificates of Indigency')
                    ->validationAttribute('submitted certificates of indigency')
                    ->suffixIcon('heroicon-o-document-text')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
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
                TextColumn::make('total_indigents')
                    ->label('Indigent Litigants'),
                TextColumn::make('with_certificate')
                    ->label('Certificates of Indigency'),
                TextColumn::make('month_year')
                    ->label('Month & Year')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Illuminate\Support\Carbon::parse($state)->format('F Y')),
            ])
            ->groups([
                Group::make('rab')
                    ->label('RAB'),
                Group::make('month_year')
                    ->label('Month & Year'),
            ])
            ->filters([
                SelectFilter::make('rab')
                    ->label('RAB')
                    ->options(\App\Enum\Branch::options()),
            ], layout: Tables\Enums\FiltersLayout::Modal)
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
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
            'index' => Pages\ListIndigentLitigants::route('/'),
            'create' => Pages\CreateIndigentLitigant::route('/create'),
            'edit' => Pages\EditIndigentLitigant::route('/{record}/edit'),
        ];
    }
}
