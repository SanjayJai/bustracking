<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Models\Route;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('start_point')->required(),
            Forms\Components\TextInput::make('end_point')->required(),
            Forms\Components\Textarea::make('stops')
                ->label('Stops (comma separated)')
                ->nullable(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('start_point')->label('Start'),
            Tables\Columns\TextColumn::make('end_point')->label('End'),
            Tables\Columns\TextColumn::make('stops')->label('Stops'),
        ]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }
}