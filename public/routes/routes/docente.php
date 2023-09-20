<?php
use App\Http\Controllers\DocenteController;


Route::middleware(['checklogin', 'checkroles:Docente,Admin'])->group(function () {
     Route::get('docente/dados', [DocenteController::class, 'index'])
          ->name('docente.dados');
     Route::post('docente/dados/editar', [DocenteController::class, 'dadosEdit'])
          ->name('docente.dados.editar.post');
     // Route::get('docente/dados/editar', [DocenteController::class, 'dados'])
     //     ->name('docente.dados.editar.get');

     Route::get('docente/propostas', [DocenteController::class, 'propostas']) //TODO: add intership lists
          ->name('docente.propostas');

     Route::post('docente/proposta/', [DocenteController::class, 'propostaStore'])
          ->name('docente.proposta.post');

     Route::get('docente/reunioes', [DocenteController::class, 'index']) //TODO: add meeting lists
          ->name('docente.reunioes');

     //docente.participacoes
     Route::get('docente/participacoes', [DocenteController::class, 'index']) //TODO: add meeting lists
          ->name('docente.participacoes');

     //list all docentes
     Route::get('docente/json', [DocenteController::class, function(){
          return response()->json(App\Models\Docente::all());

     }])->name('docente.json');

});
// Route::get('aluno/dados', [StudentController::class, 'index'])
//      ->name('aluno.dados')
//      ->middleware('checklogin')
//      ->middleware('checkpermissions:Aluno');
// Route::post('aluno/dados/editar', [StudentController::class, 'edit'])
//      ->name('aluno.dados.editar')
//      ->middleware('checklogin')
//      ->middleware('checkpermissions:Aluno');;