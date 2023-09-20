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
 * Class Defesaintermedia
 * 
 * @property string|null $relatorio
 * @property string|null $anexo
 * @property Carbon|null $data
 * @property string|null $comentarios
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $proposta_id
 * @property string|null $nao_aluno_utilizador_email
 * @property string|null $classificacao_designacao
 * 
 * @property Proposta $proposta
 * @property NaoAluno|null $nao_aluno
 * @property Classificacao|null $classificacao
 *
 * @package App\Models
 */
class Defesaintermedia extends Model
{
	use ModelObservableTrait;
	const RELATORIO = 'relatorio';
	const ANEXO = 'anexo';
	const DATA = 'data';
	const COMENTARIOS = 'comentarios';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	const PROPOSTA_ID = 'proposta_id';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	const CLASSIFICACAO_DESIGNACAO = 'classificacao_designacao';
	protected $table = 'defesaintermedia';
	protected $primaryKey = 'proposta_id';
	public $incrementing = false;

	protected $casts = [
		self::DATA => 'datetime',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::RELATORIO,
		self::ANEXO,
		self::DATA,
		self::COMENTARIOS,
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::CLASSIFICACAO_DESIGNACAO
	];

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Defesaintermedia::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function classificacao(): BelongsTo
	{
		return $this->belongsTo(Classificacao::class, Defesaintermedia::CLASSIFICACAO_DESIGNACAO);
	}
}
