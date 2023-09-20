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
 * Class Coordenar
 * 
 * @property int $id
 * @property Carbon $data_inicio
 * @property Carbon|null $data_fim
 * @property int $curso_id
 * @property string $coordenador_nao_aluno_utilizador_email
 * 
 * @property Curso $curso
 * @property Coordenador $coordenador
 *
 * @package App\Models
 */
class Coordenar extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const DATA_INICIO = 'data_inicio';
	const DATA_FIM = 'data_fim';
	const CURSO_ID = 'curso_id';
	const COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL = 'coordenador_nao_aluno_utilizador_email';
	protected $table = 'coordenar';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DATA_INICIO => 'datetime',
		self::DATA_FIM => 'datetime',
		self::CURSO_ID => 'int'
	];

	protected $fillable = [
		self::DATA_INICIO,
		self::DATA_FIM,
		self::CURSO_ID,
		self::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL
	];

	public function curso(): BelongsTo
	{
		return $this->belongsTo(Curso::class);
	}

	public function coordenador(): BelongsTo
	{
		return $this->belongsTo(Coordenador::class, Coordenar::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
