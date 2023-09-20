<?php
use App\Http\Controllers\StudentController;


Route::middleware(['checklogin', 'checkroles:Aluno'])->group(function () {
    Route::get('aluno/dados', [StudentController::class, 'index'])
         ->name('aluno.dados');
    Route::post('aluno/dados/editar', [StudentController::class, 'dadosEdit'])
         ->name('aluno.dados.editar.post');
     Route::get('aluno/dados/editar', [StudentController::class, 'dados'])
         ->name('aluno.dados.editar.get');
    
    Route::get('aluno/estagios' , [StudentController::class, 'index']) //TODO: add intership lists
         ->name('aluno.estagios');
    
    Route::get('aluno/reunioes' , [StudentController::class, 'index']) //TODO: add meeting lists
         ->name('aluno.reunioes');
         

});

Route::post('aluno/validate/email', [StudentController::class, 'validateStudentEmail'])
          ->name('aluno.validate.email.post');
// Route::get('aluno/dados', [StudentController::class, 'index'])
//      ->name('aluno.dados')
//      ->middleware('checklogin')
//      ->middleware('checkpermissions:Aluno');
// Route::post('aluno/dados/editar', [StudentController::class, 'edit'])
//      ->name('aluno.dados.editar')
//      ->middleware('checklogin')
//      ->middleware('checkpermissions:Aluno');;