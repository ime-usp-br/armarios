<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;





Route::get('/', [ArmarioController::class, 'index']);

Route::get('/armarios/criacaoEmLote', [ArmarioController::class, 'criacaoEmLote'])->name('armarios.criacaoEmLOte');
Route::resource('armarios',ArmarioController::class);