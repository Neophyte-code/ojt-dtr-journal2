<?php

namespace App\Filament\Intern\Resources\DailyTimeRecords\Widgets;

use App\Models\DtrLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DtrStatsWidget extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        $userId = Auth::id();

        $stats = DtrLog::where('user_id', $userId)
            ->selectRaw('SUM(work_minutes) as total_work, SUM(late_minutes) as total_late')
            ->first();

        $totalDays = DtrLog::where('user_id', $userId)
            ->distinct('work_date')
            ->count('work_date');

        return [
            Stat::make('Total Hours', $this->formatTime($stats->total_work ?? 0))
                ->description('Credited work time')
                ->color('success'),

            Stat::make('Total Days', $totalDays)
                ->description('Days with recorded logs'),

            Stat::make('Overall Late', $this->formatTime($stats->total_late ?? 0))
                ->description('Total tardiness recorded')
                ->color('danger'),
        ];
    }

    // function to format time
    private function formatTime(int $totalMinutes): string
    {
        // Use abs() to convert negative to positive
        $totalMinutes = abs($totalMinutes);

        if ($totalMinutes === 0) {
            return '0';
        }

        $hours = floor($totalMinutes / 60);
        $mins = $totalMinutes % 60;

        return $hours > 0 ? "{$hours}h {$mins}m" : "{$mins}m";
    }
}
