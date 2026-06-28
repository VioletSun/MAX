<?php

use Illuminate\Support\Facades\Route;
use VioletSun\MAX\Controllers\MaxController;


Route::prefix('v1')->group(function () {
    Route::prefix('max')->group(function () {
        Route::get('webhook', [MaxController::class, 'webhook'])->name('api.max.webhook');
        Route::get('/', [MaxController::class, 'index'])->name('api.max.index');
        Route::post('action', [MaxController::class, 'action'])->name('api.max.action');
    });
});
