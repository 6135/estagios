<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Gestor;
use App\Models\PapelUtilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $path)
    {
        // return Storage::disk('cv')->response($path);

        abort_if(
            ! Storage::disk('cv') ->exists($path),
            403
        );
        //To be able to acces the file it has to be owner or admin
        $requester = session()->get('user');
        if($requester && $requester->hasRole(PapelUtilizador::Admin)){
            dd($requester->hasRole(PapelUtilizador::Admin));
            return Storage::disk('cv')->response($path);
        } else if ($requester && $requester->hasRole(PapelUtilizador::EmpresaColab)){
            // dd($requester);

            $colab = Colaborador::find($requester->email);
            if($colab && $colab->cv == ("cv/" . $path)){
                return Storage::disk('cv')->response($path);
            }
        } 
        abort(403);
    }
}
