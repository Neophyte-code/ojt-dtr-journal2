<?php

use App\Filament\Admin\Resources\WeeklyReports\Pages\ViewWeeklyReports;
use App\Models\WeeklyReports;
use App\Models\WorkCategory;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

//uses(RefreshDatabase::class);

test("mark viewed action is disabled for certified reports", function () {
    $category = WorkCategory::first();
    $report = WeeklyReports::factory()->create([
        "certified_at" => now(),
        "work_category" => $category->id,
    ]);

    Livewire::test(ViewWeeklyReports::class, [
        "record" => $report->id,
    ])->assertActionDisabled("certify");
});
