<?php

namespace App\Filament\Driver\Resources\AssignedBusResource\Pages;

use App\Filament\Driver\Resources\AssignedBusResource;
use Filament\Resources\Pages\ListRecords;

class ListAssignedBuses extends ListRecords
{
    protected static string $resource = AssignedBusResource::class;

    protected function getActions(): array
    {
        return [];
    }
}