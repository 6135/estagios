<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Candidatura
 * 
 * @property int $id
 * @property int $ordem
 * @property int|null $perfil_adequado
 * @property Carbon $data
 * @property string $identificacao_aluno_utilizador_email
 * @property int $proposta_id
 * 
 * @property Aluno $aluno
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class Candidatura extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const ORDEM = 'ordem';
	const PERFIL_ADEQUADO = 'perfil_adequado';
	const DATA = 'data';
	const IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL = 'identificacao_aluno_utilizador_email';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'candidatura';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::ORDEM => 'int',
		self::PERFIL_ADEQUADO => 'int',
		self::DATA => 'datetime',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::ORDEM,
		self::PERFIL_ADEQUADO,
		self::DATA,
		self::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL,
		self::PROPOSTA_ID
	];

	public function aluno(): BelongsTo
	{
		return $this->belongsTo(Aluno::class, Candidatura::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
