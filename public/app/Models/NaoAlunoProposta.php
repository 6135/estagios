<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class NaoAlunoProposta
 * 
 * @property string $nao_aluno_utilizador_email
 * @property int $proposta_id
 * 
 * @property NaoAluno $nao_aluno
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class NaoAlunoProposta extends Model
{
	use ModelObservableTrait;
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'nao_aluno_proposta';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::PROPOSTA_ID => 'int'
	];

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, NaoAlunoProposta::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
