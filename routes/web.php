<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobBoardController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

// Public job board
Route::get('/', [JobBoardController::class, 'index'])->name('board.index');
Route::get('/jobs/{position:slug}', [JobBoardController::class, 'show'])->name('board.show');
Route::post('/jobs/{position}/apply', [JobBoardController::class, 'apply'])->name('board.apply');

// Embeddable widget
Route::get('/widget', [JobBoardController::class, 'widget'])->name('board.widget');

// Dashboard (would be auth-gated in production)
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::get('/positions/{position:slug}', [PositionController::class, 'show'])->name('positions.show');
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    Route::patch('/applications/{application}/stage', [ApplicationController::class, 'updateStage'])->name('applications.updateStage');
});
