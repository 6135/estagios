<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Externo
 * 
 * @property int $instituicao_nome
 * @property string $nao_aluno_utilizador_email
 * 
 * @property Instituicao $instituicao
 * @property NaoAluno $nao_aluno
 *
 * @package App\Models
 */
class Externo extends Model
{
	use ModelObservableTrait;
	const INSTITUICAO_NOME = 'instituicao_nome';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'externo';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::INSTITUICAO_NOME => 'int'
	];

	protected $fillable = [
		self::INSTITUICAO_NOME
	];

	public function instituicao(): BelongsTo
	{
		return $this->belongsTo(Instituicao::class, Externo::INSTITUICAO_NOME);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Externo::NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
