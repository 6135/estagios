<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Colaborador
 * 
 * @property string $cargo
 * @property string $telefone
 * @property bool|null $formacao
 * @property int|null $anosexperiencia
 * @property string $cv
 * @property int $empresa_id
 * @property string $nao_aluno_utilizador_email
 * 
 * @property Empresa $empresa
 * @property NaoAluno $nao_aluno
 *
 * @package App\Models
 */
class Colaborador extends Model
{
	use ModelObservableTrait;
	const CARGO = 'cargo';
	const TELEFONE = 'telefone';
	const FORMACAO = 'formacao';
	const ANOSEXPERIENCIA = 'anosexperiencia';
	const CV = 'cv';
	const EMPRESA_ID = 'empresa_id';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'colaborador';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::FORMACAO => 'bool',
		self::ANOSEXPERIENCIA => 'int',
		self::NAO_ALUNO_UTILIZADOR_EMAIL => 'string'
	];

	protected $fillable = [
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::CARGO,
		self::TELEFONE,
		self::FORMACAO,
		self::ANOSEXPERIENCIA,
		self::CV,
		self::EMPRESA_ID
	];
	public $keyType = 'string';
	public function empresa(): BelongsTo
	{
		return $this->belongsTo(Empresa::class, Colaborador::EMPRESA_ID);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public static function getFormacao(): array
	{
		return [
			['nome' => 'Mestrado ou equivalente'],

		];
	}
}
