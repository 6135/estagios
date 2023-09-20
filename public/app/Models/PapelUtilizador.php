<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class PapelUtilizador
 * 
 * @property string $tipo
 * 
 * @property Collection|Utilizador[] $utilizador
 *
 * @package App\Models
 */
class PapelUtilizador extends Model
{
	use ModelObservableTrait;
	const TIPO = 'tipo';
	const Undef = "Undefined";
    const Admin = "Admin";
    const Gestor = "Gestor";
    const EmpresaColab = "EmpresaColaborador";
    const EmpresaRepLegal = "EmpresaRepresentanteLegal";
    const Aluno = "Aluno";
    const Docente = "Docente";
    const Coordenador = "Coordenador";   
	const GestorPlataforma = "GestorPlataforma";
	protected $table = 'papel_utilizador';
	protected $primaryKey = 'tipo';
	public $incrementing = false;
	public $timestamps = false;

	//add pivot to hidden
	protected $hidden = ['pivot'];
	public function utilizadores(): BelongsToMany
	{
		return $this->belongsToMany(Utilizador::class, 'papel_utilizador_utilizador', PapelDoUtilizador::PAPEL_UTILIZADOR_TIPO, PapelDoUtilizador::UTILIZADOR_EMAIL);
	}

			/**
	 * Get the name of the role in the current locale
	 */
	public static function getName($role = self::Undef, $plural = false, $short = false) : string
	{
		if($plural)
			$plural = 2;
		else 
			$plural = 1;
		if($short)
			$short = 'short.';
		else 
			$short = '';
		switch ($role) {
			case self::Admin:
				return trans_choice('words.roles.'.$short.'Admin',$plural);
			case self::Gestor:
				return trans_choice('words.roles.'.$short.'Gestor',$plural);
			case self::EmpresaColab:
				return trans_choice('words.roles.'.$short.'EmpresaColaborador',$plural);
			case self::EmpresaRepLegal:
				return trans_choice('words.roles.'.$short.'EmpresaRepresentanteLegal',$plural);
			case self::Aluno:
				return trans_choice('words.roles.'.$short.'Aluno',$plural);
			case self::Docente:
				return trans_choice('words.roles.'.$short.'Docente',$plural);
			case self::Coordenador:
				return trans_choice('words.roles.'.$short.'Coordenador',$plural);
			default:
				return trans_choice('words.roles.'.$short.'Undefined',$plural);
		}
	}
	public function getSelfName($plural = false, $short = false) : string
	{
		return self::getName($this->tipo, $plural, $short);
	}
}
