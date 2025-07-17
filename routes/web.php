<?php

use App\Models\PrexcIndicator;
use App\Enum\Indicator;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
