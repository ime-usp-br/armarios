<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;





Route::get('/', [ArmarioController::class, 'index']);

Route::get('/armarios/create/emLote', [ArmarioController::class, 'createEmLote'])->name('armarios.createEmLote');
Route::post('/armarios/store/emLote', [ArmarioController::class, 'storeEmLote'])->name('armarios.storeEmLote');
Route::resource('armarios',ArmarioController::class);