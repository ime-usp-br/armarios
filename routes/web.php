<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;



Route::resource('armarios',ArmarioController::class);

Route::get('/', [ArmarioController::class, 'index']);
