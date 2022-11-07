<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\armariocontroller;



Route::get('/armarios',[armariocontroller::class,'index']);
Route::get('/armarios/{id}',[armariocontroller::class,'show']);
