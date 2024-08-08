<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () { 
    Route::post('/user/store', [UserController::class, 'store'])->name('UserStore');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('UserShow');

    Route::patch('/empresa', [EmpresaController::class, 'update'])->name('EmpresaUpdate');
    Route::get('/empresa', [EmpresaController::class, 'show'])->name('EmpresaShow');

    Route::get('/certificado', [CertificadoController::class, 'show'])->name('CertificadoShow');
    Route::post('/certificado/store', [CertificadoController::class, 'store'])->name('CertificadoStore');
    Route::delete('/certificado', [CertificadoController::class, 'destroy'])->name('CertificadoDestroy');

    Route::get('/configuracao', [ConfiguracaoController::class, 'show'])->name('ConfiguracaoShow');
    Route::patch('/configuracao', [ConfiguracaoController::class, 'update'])->name('ConfiguracaoUpdate');
});

Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('EmpresaStore');

Route::post('/login', [AuthController::class, 'login'])->name('Login');
Route::post('/logout', [AuthController::class, 'Logout'])->name('Logout');