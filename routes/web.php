<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InternController;


Route::get('/', function () {
    return redirect(Filament::getPanel('intern')->getUrl());
});

