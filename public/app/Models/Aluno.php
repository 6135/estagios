<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Aluno
 * 
 * @property string $documento_id
 * @property Carbon $validade
 * @property int|null $aluno_numaluno
 * @property int $aluno_medialicenciatura
 * @property float $aluno_mediamestrado
 * @property string $aluno_cv
 * @property string $aluno_telefone
 * @property string $aluno_morada
 * @property string $aluno_identificacao_id
 * @property Carbon $aluno_validade
 * @property string $documento_tipo
 * @property string $pais_nome
 * @property int $curso_id
 * @property string $utilizador_email
 * 
 * @property Documento $documento
 * @property Pais $pais
 * @property Curso $curso
 * @property Utilizador $utilizador
 * @property Collection|Candidatura[] $candidaturas
 * @property Collection|Cadeira[] $cadeira
 * @property Collection|Proposta[] $propostas
 *
 * @package App\Models
 */
class Aluno extends Model
{
	use ModelObservableTrait;
	const DOCUMENTO_ID = 'documento_id';
	const VALIDADE = 'validade';
	const ALUNO_NUMALUNO = 'aluno_numaluno';
	const ALUNO_MEDIALICENCIATURA = 'aluno_medialicenciatura';
	const ALUNO_MEDIAMESTRADO = 'aluno_mediamestrado';
	const ALUNO_CV = 'aluno_cv';
	const ALUNO_TELEFONE = 'aluno_telefone';
	const ALUNO_MORADA = 'aluno_morada';
	const ALUNO_IDENTIFICACAO_ID = 'aluno_identificacao_id';
	const ALUNO_VALIDADE = 'aluno_validade';
	const DOCUMENTO_TIPO = 'documento_tipo';
	const PAIS_CODIGO_ISO = 'pais_codigo_iso';
	const CURSO_ID = 'curso_id';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'identificacao_aluno';
	protected $primaryKey = 'utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::VALIDADE => 'datetime',
		self::ALUNO_NUMALUNO => 'int',
		self::ALUNO_MEDIALICENCIATURA => 'int',
		self::ALUNO_MEDIAMESTRADO => 'float',
		self::ALUNO_VALIDADE => 'datetime',
		self::CURSO_ID => 'int'
	];

	protected $fillable = [
		self::DOCUMENTO_ID,
		self::VALIDADE,
		self::ALUNO_NUMALUNO,
		self::ALUNO_MEDIALICENCIATURA,
		self::ALUNO_MEDIAMESTRADO,
		self::ALUNO_CV,
		self::ALUNO_TELEFONE,
		self::ALUNO_MORADA,
		self::ALUNO_IDENTIFICACAO_ID,
		self::ALUNO_VALIDADE,
		self::DOCUMENTO_TIPO,
		self::PAIS_CODIGO_ISO,
		self::CURSO_ID
	];

	public function documento(): BelongsTo
	{
		return $this->belongsTo(Documento::class, Aluno::DOCUMENTO_TIPO);
	}

	public function pais(): BelongsTo
	{
		return $this->belongsTo(Pais::class, Aluno::PAIS_CODIGO_ISO);
	}

	public function curso(): BelongsTo
	{
		return $this->belongsTo(Curso::class);
	}

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, Aluno::UTILIZADOR_EMAIL);
	}

	public function candidaturas(): HasMany
	{
		return $this->hasMany(Candidatura::class, Candidatura::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function cadeira(): BelongsToMany
	{
		return $this->belongsToMany(Cadeira::class, 'identificacao_aluno_cadeira', AlunoCadeira::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL, AlunoCadeira::CADEIRA_DESIGNACAO);
	}

	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
