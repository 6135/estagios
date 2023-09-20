<?php

//retrieve all active especializations' names
Route::get('api/especializacoes/active', function () {
    return \App\Models\Especializacao::getActiveEspecializacoesNames();
})->name('active.especializacoes');