<?php

namespace App\Filament\Driver\Resources\AssignedBusResource\Pages;

use App\Filament\Driver\Resources\AssignedBusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssignedBus extends EditRecord
{
    protected static string $resource = AssignedBusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
