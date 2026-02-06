<?php

namespace App\Filament\Resources\AdminActivities\Pages;

use App\Filament\Resources\AdminActivities\AdminActivitiesResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminActivities extends EditRecord
{
    protected static string $resource = AdminActivitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
