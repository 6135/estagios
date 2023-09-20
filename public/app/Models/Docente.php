<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Docente
 * 
 * @property string $numero_mecanografico
 * @property string|null $especializacao_nome
 * @property string $nao_aluno_utilizador_email
 * 
 * @property Especializacao|null $especializacao
 * @property NaoAluno $nao_aluno
 *
 * @package App\Models
 */
class Docente extends Model
{
	use ModelObservableTrait;
	const NUMERO_MECANOGRAFICO = 'numero_mecanografico';
	const ESPECIALIZACAO_NOME = 'especializacao_nome';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'docente';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		self::NUMERO_MECANOGRAFICO,
		self::ESPECIALIZACAO_NOME
	];

	public function especializacao(): BelongsTo
	{
		return $this->belongsTo(Especializacao::class, Docente::ESPECIALIZACAO_NOME);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Docente::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, Docente::NAO_ALUNO_UTILIZADOR_EMAIL, Utilizador::EMAIL);
	}

	/** get all docentes that have the active field in users table set to true */
	public static function getActiveDocentes(): Collection {
		return Docente::whereHas('nao_aluno', function ($query) {
			$query->whereHas('utilizador', function ($query) {
				$query->where(Utilizador::ATIVO, true);
			});
		})->get();
	}

	/** get all docentes that have the active field in users table set to true, except current logged in*/
	public static function getActiveDocentesExeptCurrent(): Collection {
		return Docente::whereHas('nao_aluno', function ($query) {
			$query->whereHas('utilizador', function ($query) {
				$query->where(Utilizador::ATIVO, true)->where(Utilizador::EMAIL, '!=', session()->get('user')->email);
			});
		})->get();
	}
}
