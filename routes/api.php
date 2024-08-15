<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Nfe\CertificadoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\DestinatarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GrupoImpostosController;
use App\Http\Controllers\ImpostosController;
use App\Http\Controllers\Nfe\NfeController;
use App\Http\Controllers\ProdutoController;
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

    Route::get('/grupoImpostos', [GrupoImpostosController::class, 'index'])->name('GrupoImpostosIndex');
    Route::get('/grupoImpostos/{id}', [GrupoImpostosController::class, 'show'])->name('GrupoImpostosShow');
    Route::post('/grupoImpostos/store', [GrupoImpostosController::class, 'store'])->name('GrupoImpostosStore');
    Route::patch('/grupoImpostos/update', [GrupoImpostosController::class, 'update'])->name('GrupoImpostosUpdate');
    Route::delete('/grupoImpostos/delete/{id}', [GrupoImpostosController::class, 'destroy'])->name('GrupoImpostosDelete');

    Route::get('/impostos', [ImpostosController::class, 'index'])->name('ImpostosIndex');
    Route::get('/impostos/{id}', [ImpostosController::class, 'show'])->name('ImpostosShow');
    Route::patch('/impostos/update', [ImpostosController::class, 'update'])->name('Impostosupdate');

    Route::get('/destinatario', [DestinatarioController::class, 'index'])->name('DestinatarioIndex');
    Route::get('/destinatario/{id}', [DestinatarioController::class, 'show'])->name('DestinatarioShow');
    Route::post('/destinatario/store', [DestinatarioController::class, 'store'])->name('DestinatarioStore');
    Route::patch('/destinatario/update', [DestinatarioController::class, 'update'])->name('DestinatarioUpdate');
    Route::delete('/destinatario/delete/{id}', [DestinatarioController::class, 'destroy'])->name('DestinatarioDelete');

    Route::get('/produto', [ProdutoController::class, 'index'])->name('ProdutoIndex');
    Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('ProdutoShow');
    Route::post('/produto/store', [ProdutoController::class, 'store'])->name('ProdutoStore');
    Route::patch('/produto/update', [ProdutoController::class, 'update'])->name('ProdutoUpdate');
    Route::delete('/produto/delete/{id}', [ProdutoController::class, 'destroy'])->name('ProdutoDelete');

    Route::get('/nfe', [NfeController::class, 'index'])->name('NfeIndex');
    Route::get('/nfe/{id}', [NfeController::class, 'show'])->name('NfeShow');
    Route::post('/nfe/store', [NfeController::class, 'store'])->name('NfeStore');
    Route::patch('/nfe/update', [NfeController::class, 'update'])->name('NfeUpdate');
    Route::post('/nfe/storeProduto', [NfeController::class, 'storeProdutoNfe'])->name('NfeStoreProduto');
    Route::post('/nfe/enviar', [NfeController::class, 'enviar'])->name('NfeEnviar');
    Route::delete('/nfe/delete/{id}', [NfeController::class, 'destroy'])->name('NfeDelete');

});

Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('EmpresaStore');

Route::post('/login', [AuthController::class, 'login'])->name('Login');
Route::post('/logout', [AuthController::class, 'Logout'])->name('Logout');