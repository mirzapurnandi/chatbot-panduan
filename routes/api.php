<?php

use App\Http\Controllers\API\DlrController;
use App\Http\Controllers\EngineController;
use Illuminate\Support\Facades\Route;

Route::post('/dlr/listen-dlr', [DlrController::class, 'index']);
Route::get('/get-qr', [EngineController::class, 'getQR'])->name('engine.get-qr');
Route::get('/get-status', [EngineController::class, 'getStatus'])->name('engine.get-status');
Route::get('/disconnect', [EngineController::class, 'Disconnect'])->name('engine.disconnect');
