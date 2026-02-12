<?php

use App\Filament\Intern\Resources\DailyTimeRecords\Widgets\DtrStatsWidget;
use App\Models\DtrLog;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('intern'));
});

// helper function to simulate in and out
function simulateSession($user, $date, $inTime, $outTime, $lateMins = 0, $workMins = 0)
{
    DtrLog::create([
        'user_id' => $user->id,
        'type' => 1,
        'work_date' => $date,
        'recorded_at' => "{$date} {$inTime}",
        'late_minutes' => $lateMins,
    ]);

    DtrLog::create([
        'user_id' => $user->id,
        'type' => 2,
        'work_date' => $date,
        'recorded_at' => "{$date} {$outTime}",
        'work_minutes' => $workMins,
    ]);
}

it('shows correct stats for a perfect 8-hour day', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $today = '2024-02-01';

    simulateSession($user, $today, '08:00:00', '12:00:00', 0, 240);
    simulateSession($user, $today, '13:00:00', '17:00:00', 0, 240);

    Livewire::test(DtrStatsWidget::class)
        ->assertSee('8h 0m')
        ->assertSee('1')
        ->assertSee('0');
});

it('shows correct stats for a late day', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $today = '2024-02-01';

    // 15m late, worked 225m
    simulateSession($user, $today, '08:15:00', '12:00:00', 15, 225);
    // 15m late, worked 225m
    simulateSession($user, $today, '13:15:00', '17:00:00', 15, 225);

    Livewire::test(DtrStatsWidget::class)
        ->assertSee('7h 30m')
        ->assertSee('1')
        ->assertSee('30m');
});

it('shows correct stats for an undertime day', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $today = '2024-02-01';

    simulateSession($user, $today, '08:00:00', '12:00:00', 0, 240);
    simulateSession($user, $today, '13:00:00', '16:00:00', 0, 180);

    Livewire::test(DtrStatsWidget::class)
        ->assertSee('7h 0m')
        ->assertSee('1')
        ->assertSee('0');
});

it('shows correct stats for a half day', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $today = '2024-02-01';

    simulateSession($user, $today, '08:00:00', '12:00:00', 0, 240);

    Livewire::test(DtrStatsWidget::class)
        ->assertSee('4h 0m')
        ->assertSee('1')
        ->assertSee('0');
});
