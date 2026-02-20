<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewConnectionController;
use App\Http\Controllers\ReconnectionController;
use App\Http\Controllers\SeniorCitizenController;
use App\Http\Controllers\ChangeInfoController;
use App\Http\Controllers\ChangeMeterController;
use App\Http\Controllers\NetMeteringController;
use App\Http\Controllers\NoPowerController;


// Home
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Services Routes
Route::prefix('services')->group(function () {

    Route::get('/new-connection', [NewConnectionController::class, 'index'])
        ->name('services.new-connection');

    Route::post('/new-connection', [NewConnectionController::class, 'store'])
        ->name('services.new-connection.store');

    Route::get('/reconnection', [ReconnectionController::class, 'index'])
    ->name('services.reconnection');

    Route::post('/reconnection', [ReconnectionController::class, 'store'])
    ->name('services.reconnection.store');

     Route::get('/senior-citizen', [SeniorCitizenController::class, 'index'])
    ->name('services.senior-citizen');

    Route::post('/senior-citizen', [SeniorCitizenController::class, 'store'])
    ->name('services.senior-citizen.store');

    Route::get('/change-info',[ChangeInfoController::class, 'index'])
    ->name('services.change-info');

    Route::post('/change-info', [ChangeInfoController::class, 'store'])
    ->name('services.change-info.store');

    Route::get('/change-meter', [ChangeMeterController::class, 'index'])
    ->name('services.change-meter');

    Route::post('/change-meter', [ChangeMeterController::class, 'store'])
    ->name('services.change-meter.store');

    Route::get('/net-metering', [NetMeteringController::class, 'index'])
    ->name('services.net-metering');

    Route::post('/net-metering', [NetMeteringController::class, 'store'])
    ->name('services.net-metering.store');

    Route::get('/no-power', [NoPowerController::class, 'index'])
    ->name('services.no-power');

    Route::post('/no-power', [NoPowerController::class, 'store'])
    ->name('services.no-power.store');

});
