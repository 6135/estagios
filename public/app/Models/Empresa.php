<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Empresa
 * 
 * @property string $nomeempresa
 * @property string|null $acronimo
 * @property string $nif
 * @property string $morada
 * @property string $telefone
 * @property string|null $url
 * @property string $atividade
 * @property string $pais_nome
 * @property string $nao_aluno_utilizador_email
 * @property int $id
 * 
 * @property Pais $pais
 * @property NaoAluno $nao_aluno
 * @property Collection|Colaborador[] $colaboradores
 * @property Collection|Representante[] $representantes
 *
 * @package App\Models
 */
class Empresa extends Model
{
	use ModelObservableTrait;
	const NOMEEMPRESA = 'nomeempresa';
	const ACRONIMO = 'acronimo';
	const NIF = 'nif';
	const MORADA = 'morada';
	const TELEFONE = 'telefone';
	const URL = 'url';
	const ATIVIDADE = 'atividade';
	const PAIS_CODIGO_ISO = 'pais_codigo_iso';
	const ID = 'id';
	protected $table = 'empresa';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = false;

	protected $fillable = [
		self::NOMEEMPRESA,
		self::ACRONIMO,
		self::NIF,
		self::MORADA,
		self::TELEFONE,
		self::URL,
		self::ATIVIDADE,
		self::PAIS_CODIGO_ISO
	];

	public function pais(): BelongsTo
	{
		return $this->belongsTo(Pais::class, Empresa::PAIS_CODIGO_ISO);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Empresa::ID);
	}

	public function colaboradores(): HasMany
	{
		return $this->hasMany(Colaborador::class, Colaborador::EMPRESA_ID);
	}

	public function representantes(): HasMany
	{
		return $this->hasMany(Representante::class, Representante::EMPRESA_ID);
	}

	// HasMany gestores
	public function gestores(): HasMany
	{
		return $this->hasMany(Gestor::class, Gestor::EMPRESA_ID);
	}
}
