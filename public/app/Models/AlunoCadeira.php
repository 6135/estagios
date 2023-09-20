<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AlunoCadeira
 * 
 * @property string $identificacao_aluno_utilizador_email
 * @property string $cadeira_designacao
 * 
 * @property Aluno $aluno
 * @property Cadeira $cadeira
 *
 * @package App\Models
 */
class AlunoCadeira extends Model
{
	use ModelObservableTrait;
	const IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL = 'identificacao_aluno_utilizador_email';
	const CADEIRA_DESIGNACAO = 'cadeira_designacao';
	protected $table = 'identificacao_aluno_cadeira';
	public $incrementing = false;
	public $timestamps = false;

	public function aluno(): BelongsTo
	{
		return $this->belongsTo(Aluno::class, AlunoCadeira::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function cadeira(): BelongsTo
	{
		return $this->belongsTo(Cadeira::class, AlunoCadeira::CADEIRA_DESIGNACAO);
	}
}
