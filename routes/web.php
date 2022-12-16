<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\UserController;





Route::get('/', [ArmarioController::class, 'index']);
Route::get('/emprestimo', [EmprestimoController::class, 'index']);
Route::get('/armarios/{armario}/emprestimo',[EmprestimoController::class,'emprestimo'])->name("armarios.emprestimo");


Route::get('/armarios/create/emLote', [ArmarioController::class, 'createEmLote'])->name('armarios.createEmLote');
Route::post('/armarios/store/emLote', [ArmarioController::class, 'storeEmLote'])->name('armarios.storeEmLote');
Route::resource('armarios',ArmarioController::class);
Route::resource('emprestimos',EmprestimoController::class);
Route::resource('users', UserController::class);