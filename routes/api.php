<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\GenerationController;
use App\Http\Controllers\Api\IntakeController;
use App\Http\Controllers\MeditationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api.token')->group(function (): void {
    Route::post('/intakes', [IntakeController::class, 'store'])->name('intakes.store');
    Route::get('/intakes/{intakeId}', [IntakeController::class, 'show'])->name('intakes.show');

    Route::post('/generations', [GenerationController::class, 'store'])->name('generations.store');
    Route::get('/generations/{requestId}', [GenerationController::class, 'show'])->name('generations.show');
    Route::get('/generations/{requestId}/result', [GenerationController::class, 'result'])->name('generations.result');
    Route::post('/generations/{requestId}/retry', [GenerationController::class, 'retry'])->name('generations.retry');
    Route::get('/generations/{requestId}/events', [GenerationController::class, 'events'])->name('generations.events');

    Route::get('/assets/{assetId}', [AssetController::class, 'show'])->name('assets.show');
    Route::get('/assets/{assetId}/download', [AssetController::class, 'download'])->name('assets.download');

    Route::get('/meditations', [MeditationController::class, 'index'])->name('meditations.index');
});
