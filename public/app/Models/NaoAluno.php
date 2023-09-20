<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class NaoAluno
 * 
 * @property string $utilizador_email
 * 
 * @property Utilizador $utilizador
 * @property Docente $docente
 * @property Colaborador $colaborador
 * @property Gestor $gestor
 * @property Representante $representante
 * @property Collection|Defesaintermedia[] $defesaintermedia
 * @property Collection|Juri[] $juris
 * @property Externo $externo
 * @property Coordenador $coordenador
 * @property GestorPlataforma $gestor_plataforma
 * @property Collection|Proposta[] $orienta
 * @property Collection|Proposta[] $propostas
 *
 * @package App\Models
 */
class NaoAluno extends Model
{
	use ModelObservableTrait;
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'nao_aluno';
	protected $primaryKey = 'utilizador_email';
	public $incrementing = false;
	public $timestamps = false;
	public $keyType = 'string';

	protected $fillable = [
		'utilizador_email'
	];
	//casts
	protected $casts = [
		self::UTILIZADOR_EMAIL => 'string'
	];
	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, NaoAluno::UTILIZADOR_EMAIL);
	}

	public function docente(): HasOne
	{
		return $this->hasOne(Docente::class, Docente::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function colaborador(): HasOne
	{
		return $this->hasOne(Colaborador::class, Colaborador::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function gestor(): HasOne
	{
		return $this->hasOne(Gestor::class, Gestor::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function representante(): HasOne
	{
		return $this->hasOne(Representante::class, Representante::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function defesaintermedia(): HasMany
	{
		return $this->hasMany(Defesaintermedia::class, Defesaintermedia::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function juris(): HasMany
	{
		return $this->hasMany(Juri::class, Juri::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function externo(): HasOne
	{
		return $this->hasOne(Externo::class, Externo::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function coordenador(): HasOne
	{
		return $this->hasOne(Coordenador::class, Coordenador::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function gestor_plataforma(): HasOne
	{
		return $this->hasOne(GestorPlataforma::class, GestorPlataforma::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	//orientacoes
	public function orienta(): BelongsToMany
	{
		return $this->belongsToMany(Proposta::class, 'nao_aluno_proposta', Proposta::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	//criou
	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
