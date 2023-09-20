<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Juri
 * 
 * @property int $id
 * @property string $nao_aluno_utilizador_email
 * @property string $papel_juri_funcao
 * @property int $proposta_id
 * 
 * @property NaoAluno $nao_aluno
 * @property PapelJuri $papel_juri
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class Juri extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	const PAPEL_JURI_FUNCAO = 'papel_juri_funcao';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'juri';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::PAPEL_JURI_FUNCAO,
		self::PROPOSTA_ID
	];

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Juri::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function papel_juri(): BelongsTo
	{
		return $this->belongsTo(PapelJuri::class, Juri::PAPEL_JURI_FUNCAO);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
