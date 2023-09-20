<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Curso
 * 
 * @property int $id
 * @property string $acronimo
 * @property int $ano_criacao
 * @property string $nome
 * @property string $descricao
 * 
 * @property Collection|Coordenar[] $coordenars
 * @property Collection|EdicaoEstagio[] $edicao_estagios
 * @property Collection|Disciplina[] $disciplinas
 * @property Collection|Especializacao[] $especializacoes
 * @property Collection|Aluno[] $alunos
 *
 * @package App\Models
 */
class Curso extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const ACRONIMO = 'acronimo';
	const ANO_CRIACAO = 'ano_criacao';
	const NOME = 'nome';
	const DESCRICAO = 'descricao';

	const ATIVO = 'active';
	protected $table = 'curso';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::ANO_CRIACAO => 'int'
	];

	protected $fillable = [
		self::ACRONIMO,
		self::ANO_CRIACAO,
		self::NOME,
		self::DESCRICAO
	];

	public function coordenars(): HasMany
	{
		return $this->hasMany(Coordenar::class);
	}

	public function edicao_estagios(): HasMany
	{
		return $this->hasMany(EdicaoEstagio::class);
	}

	public function disciplinas(): HasMany
	{
		return $this->hasMany(Disciplina::class);
	}

	public function especializacoes(): HasMany
	{
		return $this->hasMany(Especializacao::class);
	}

	public function alunos(): HasMany
	{
		return $this->hasMany(Aluno::class);
	}

	/**
	 * active scope
	 */
	public function scopeActive(Builder $query) : void
	{
		$query->where(self::ATIVO, true);
	}
}
