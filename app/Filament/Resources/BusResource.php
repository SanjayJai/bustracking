<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusResource\Pages;
use App\Models\Bus;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusResource extends Resource
{
    protected static ?string $model = Bus::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Bus Name')
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->label('Bus Image')
                    ->image()
                    ->directory('buses')
                    ->disk('public')
                    ->nullable(),

                Forms\Components\Select::make('ac_type')
                    ->label('AC Type')
                    ->options(['AC' => 'AC', 'Non-AC' => 'Non-AC'])
                    ->required(),

                Forms\Components\Select::make('driver_id')
                    ->label('Assigned Driver')
                    ->searchable()
                    ->options(
                        User::where('role', 'driver')->pluck('name', 'id')
                    )
                    ->nullable(),

                // If you have routes:
                Forms\Components\Select::make('route_id')
                    ->label('Assigned Route')
                    ->relationship('route', 'name')
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Bus Name'),
                Tables\Columns\ImageColumn::make('image')->label('Bus Image')->disk('public'),
                Tables\Columns\TextColumn::make('ac_type')->label('AC Type'),
                Tables\Columns\TextColumn::make('driver.name')->label('Driver Name'),
                Tables\Columns\TextColumn::make('driver.email')->label('Driver Email'),
                Tables\Columns\TextColumn::make('route.name')->label('Route'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuses::route('/'),
            'create' => Pages\CreateBus::route('/create'),
            'edit' => Pages\EditBus::route('/{record}/edit'),
        ];
    }
}