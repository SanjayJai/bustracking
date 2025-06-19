<?php

namespace App\Filament\Driver\Resources;

use App\Models\Bus;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignedBusResource extends Resource
{
    protected static ?string $model = Bus::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'My Assigned Bus';


    public static function getEloquentQuery(): Builder
    {
        // Filter by the logged-in user's ID
        return static::$model::query()->where('driver_id', auth()->id());
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Bus Name'),
                Tables\Columns\ImageColumn::make('image')->label('Image')->disk('public'),
                Tables\Columns\TextColumn::make('ac_type')->label('AC Type'),
                Tables\Columns\TextColumn::make('route.name')->label('Route'),
            ])
            ->actions([]);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Driver\Resources\AssignedBusResource\Pages\ListAssignedBuses::route('/'),
        ];
    }
}