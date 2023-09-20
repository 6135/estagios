<?php
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\RepresentanteController;
use App\Models\Colaborador;
use App\Models\PapelUtilizador;

//confirm email
Route::post('/confirm/empresa', [CompanyController::class, 'confirmEmail'])->name('empresa.confirmar.post');
Route::post('/confirm/empresa/rep', [RepresentanteController::class, 'confirmEmail'])->name('rep.confirmar.post');
Route::post('/confirm/empresa/gestor', [GestorController::class, 'confirmEmail'])->name('gestor.confirmar.post');
Route::post('/confirm/empresa/colaborador', [ColaboradorController::class, 'confirmEmail'])->name('colab.confirmar.post');


Route::post('gestor/empresa/request/new/gestor', [CompanyController::class, 'requestNewGestor'])
     ->name('empresa.request.new.gestor.post');
Route::post('gestor/empresa/request/new/rep', [CompanyController::class, 'requestNewRep'])
   ->name('empresa.request.new.rep.post');
Route::post('gestor/empresa/request/new/colab', [CompanyController::class, 'requestNewColab'])
   ->name('empresa.request.new.colab.post');

Route::get('gestor/empresa/colaboradores', [GestorController::class, 'viewColaboradores'])
   ->middleware('checkroles:'.PapelUtilizador::Gestor . ',' . PapelUtilizador::EmpresaRepLegal . ',' . PapelUtilizador::Admin)
   ->name('empresa.colaboradores');

Route::get('gestor/empresa/colaboradores/json', [GestorController::class, 'viewColaboradoresJSON'])
   ->middleware('checkroles:'.PapelUtilizador::Gestor . ',' . PapelUtilizador::EmpresaRepLegal . ',' . PapelUtilizador::Admin)
   ->name('empresa.colaboradores.json');

///For gestor
Route::middleware(['checklogin', 'checkroles:'.PapelUtilizador::Gestor . ',' . PapelUtilizador::Admin])->group(function () {
    
   Route::get('gestor/empresa/dados', [GestorController::class, 'index'])
         ->name('empresa.dados');
   Route::post('gestor/empresa/changeuserstate', [GestorController::class, 'changeUserState'])
         ->name('empresa.change.user.state');
   Route::post('gestor/empresa/edituser', [GestorController::class, 'editUser'])
         ->name('empresa.edit.user');
});

Route::middleware(['checklogin', 'checkroles:'.PapelUtilizador::Gestor . ','.PapelUtilizador::EmpresaRepLegal.','.PapelUtilizador::Admin])->group(function () {
     
    Route::post('empresa/dados/editar', [CompanyController::class, 'edit'])
    ->name('empresa.dados.editar.post');

 });

Route::get('/cv/{path}', FilesController::class);