<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Especializacao
 * 
 * @property string $nome
 * @property string|null $descricaocurta
 * @property string $descricao
 * @property int $curso_id
 * 
 * @property Curso $curso
 * @property Collection|Docente[] $docentes
 * @property Collection|Proposta[] $proposta
 *
 * @package App\Models
 */
class Especializacao extends Model
{
	use ModelObservableTrait;
	const NOME = 'nome';
	const DESCRICAOCURTA = 'descricaocurta';
	const DESCRICAO = 'descricao';
	const CURSO_ID = 'curso_id';
	protected $table = 'especializacao';
	protected $primaryKey = 'nome';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::CURSO_ID => 'int'
	];

	protected $fillable = [
		self::DESCRICAOCURTA,
		self::DESCRICAO,
		self::CURSO_ID
	];

	public function curso(): BelongsTo
	{
		return $this->belongsTo(Curso::class);
	}

	public function docentes(): HasMany
	{
		return $this->hasMany(Docente::class, Docente::ESPECIALIZACAO_NOME);
	}

	public function proposta(): BelongsToMany
	{
		return $this->belongsToMany(Proposta::class, 'especializacao_proposta', EspecializacaoProposta::ESPECIALIZACAO_NOME);
	}

	//get all especializacoes where curso's active property is true
	public static function getActiveEspecializacoes(): Collection
	{
		return self::whereHas('curso', function ($query) {
			$query->where(Curso::ATIVO, true);
		})->get();
	}

	//get all especializacoes where curso's active property is true but just an array of their names
	public static function getActiveEspecializacoesNames() : array {
		return self::getActiveEspecializacoes()->pluck(self::NOME)->toArray();
	}		

}
