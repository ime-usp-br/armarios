<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\UserController;


Route::get('/', [EmprestimoController::class, 'index']);  
Route::get('/armarios', [ArmarioController::class, 'index'])->middleware(['auth']);
Route::get('/armarios/emprestados', [ArmarioController::class, 'armariosEmprestados'])->middleware(['auth']);

Route::post('/armarios/{armario}/liberar', [ArmarioController::class, 'liberar'])->name('armarios.liberar');
Route::post('/armarios/{armario}/bloquear', [ArmarioController::class, 'bloquear'])->name('armarios.bloquear');
Route::post('/armarios/{armario}/desbloquear', [ArmarioController::class, 'desbloquear'])->name('armarios.desbloquear');


Route::post('/armarios/emprestimo',[EmprestimoController::class,'emprestimo'])->name("armarios.emprestimo");

Route::resource('armarios',ArmarioController::class);
Route::resource('emprestimos',EmprestimoController::class);
Route::resource('users', UserController::class);
Route::get('/mail-preview', function () {
    return new App\Mail\SistemaDeArmarios(auth()->user(), $armario);
});


