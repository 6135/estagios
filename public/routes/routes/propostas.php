<?php
use App\Models\Curso;
use App\Models\EdicaoEstagio;

//get a list of areas de especializacao from the database of a given curso

Route::get('/areas/{edicao?}', function (int $edicao = null) {
    $edicao = EdicaoEstagio::active()->where('id', $edicao)->first();
    if($edicao) {
        $curso = $edicao->curso()->first();
        if($curso) {
            $especializacoes = $curso->especializacoes()->get();
            if($especializacoes->isEmpty()) {
                $data = [
                    'success' => false,
                    'message' => $especializacoes,
                    'redirect' => false,
                ];
                return response()->json($data);
            } else {
                $data = [
                    'success' => true,
                    'message' => $especializacoes,
                    'redirect' => false,
                ];
                return response()->json($data);
            }
        }
    }
    $data = [
        'success' => false,
        'message' => "Err",
        'redirect' => false,
    ];
    return response()->json($data);
})->name('areasEspecializacaoCurso');
