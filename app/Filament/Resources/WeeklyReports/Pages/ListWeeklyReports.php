<?php

namespace App\Filament\Resources\WeeklyReports\Pages;

use App\Filament\Resources\WeeklyReports\WeeklyReportsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\WeeklyReports\Widgets\StatsOverview;

class ListWeeklyReports extends ListRecords
{
    protected static string $resource = WeeklyReportsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::class,
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
