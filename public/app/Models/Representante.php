<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Representante
 * 
 * @property string $cargo
 * @property string $telefone
 * @property int $empresa_id
 * @property string $nao_aluno_utilizador_email
 * 
 * @property Empresa $empresa
 * @property NaoAluno $nao_aluno
 * @property Collection|Proposta[] $propostas
 *
 * @package App\Models
 */
class Representante extends Model
{
	use ModelObservableTrait;
	const CARGO = 'cargo';
	const TELEFONE = 'telefone';
	const EMPRESA_ID = 'empresa_id';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'representante';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::CARGO,
		self::TELEFONE,
		self::EMPRESA_ID
	];

	public function empresa(): BelongsTo
	{
		return $this->belongsTo(Empresa::class, Representante::EMPRESA_ID);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Representante::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::REPRESENTANTE_NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
