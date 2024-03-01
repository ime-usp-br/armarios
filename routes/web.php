<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArmarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('Empréstimo de armários'); 
});


Route::get('/armarios', [ArmarioController::class, 'index'])->middleware(['auth']);
Route::post('/armarios/{armario}/liberar', [ArmarioController::class, 'liberar'])->name('armarios.liberar');

Route::get('/', [EmprestimoController::class, 'index']);
Route::post('/armarios/emprestimo',[EmprestimoController::class,'emprestimo'])->name("armarios.emprestimo");
Route::get('/armarios/create/emLote', [ArmarioController::class, 'createEmLote'])->name('armarios.createEmLote');
Route::post('/armarios/store/emLote', [ArmarioController::class, 'storeEmLote'])->name('armarios.storeEmLote');
Route::resource('armarios',ArmarioController::class);
Route::resource('emprestimos',EmprestimoController::class);
Route::resource('users', UserController::class);
Route::get('/mail-preview', function () {
    return new App\Mail\SistemaDeArmarios(auth()->user(), $armario);
});
Route::get('/armarios/meuarmario', [EmprestimoController::class, 'meuarmario'])->name("emprestimos.meuarmario");

