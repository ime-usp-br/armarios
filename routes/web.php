<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;



Route::resource('armarios',ArmarioController::class);
