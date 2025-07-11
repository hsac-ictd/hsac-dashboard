<?php

namespace App\Filament\Clusters\Prexc\Resources;

use App\Filament\Clusters\Prexc;
use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\Pages;
use App\Filament\Clusters\Prexc\Resources\MonthlyCaseWorkloadResource\RelationManagers;
use App\Models\MonthlyCaseWorkload;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthlyCaseWorkloadResource extends Resource
{
    protected static ?string $model = MonthlyCaseWorkload::class;
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $pluralModelLabel = "Disposed & Handled Data";
    protected static ?string $modelLabel = "Disposed & Handled Data";
    protected static ?string $navigationLabel = "Disposed & Handled";
    protected static ?string $cluster = Prexc::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('total_disposed')
                    ->label('Total Disposed Cases')
                    ->validationAttribute('total disposed cases')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                TextInput::make('total_handled')
                    ->label('Total Handled Cases')
                    ->validationAttribute('total handled cases')
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
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        //Always set the month_year to the start of the month
                        if ($state) {
                            $set('month_year', \Illuminate\Support\Carbon::parse($state)->startOfMonth());
                            $set('year', \Illuminate\Support\Carbon::parse($state)->startOfMonth()->year);
                        }
                    }),
                Hidden::make('year')
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('total_disposed')
                    ->label('Total Disposed'),
                TextColumn::make('total_handled')
                    ->label('Total Handled'),
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
            'index' => Pages\ListMonthlyCaseWorkloads::route('/'),
            'create' => Pages\CreateMonthlyCaseWorkload::route('/create'),
            'edit' => Pages\EditMonthlyCaseWorkload::route('/{record}/edit'),
        ];
    }
}
