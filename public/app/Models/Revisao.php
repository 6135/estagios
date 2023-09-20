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
 * Class Revisao
 * 
 * @property int $id
 * @property string|null $motivo
 * @property Carbon|null $data
 * @property string $coordenador_nao_aluno_utilizador_email
 * @property int $proposta_id
 * 
 * @property Coordenador $coordenador
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class Revisao extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const MOTIVO = 'motivo';
	const DATA = 'data';
	const COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL = 'coordenador_nao_aluno_utilizador_email';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'revisao';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DATA => 'datetime',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::MOTIVO,
		self::DATA,
		self::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL,
		self::PROPOSTA_ID
	];

	public function coordenador(): BelongsTo
	{
		return $this->belongsTo(Coordenador::class, Revisao::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
