<?php

namespace App\Filament\Resources\AdminActivities\Pages;

use App\Filament\Resources\AdminActivities\AdminActivitiesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAdminActivities extends ViewRecord
{
    protected static string $resource = AdminActivitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
        ];
    }
}
