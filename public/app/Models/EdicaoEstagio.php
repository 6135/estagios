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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class EdicaoEstagio
 * 
 * @property int $id
 * @property string $disciplina
 * @property Carbon|null $inicio_estagio
 * @property Carbon|null $fim_estagio
 * @property bool $ativo
 * @property int $curso_id
 * 
 * @property Curso $curso
 * @property Collection|Visivel[] $visivels
 * @property Collection|Duracao[] $duracaos
 * @property Collection|Proposta[] $propostas
 *
 * @package App\Models
 */
class EdicaoEstagio extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const DISCIPLINA = 'disciplina';
	const INICIO_ESTAGIO = 'inicio_estagio';
	const FIM_ESTAGIO = 'fim_estagio';
	const ATIVO = 'ativo';
	const CURSO_ID = 'curso_id';
	protected $table = 'edicao_estagio';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::INICIO_ESTAGIO => 'datetime',
		self::FIM_ESTAGIO => 'datetime',
		self::ATIVO => 'bool',
		self::CURSO_ID => 'int'
	];

	protected $fillable = [
		self::DISCIPLINA,
		self::INICIO_ESTAGIO,
		self::FIM_ESTAGIO,
		self::ATIVO,
		self::CURSO_ID
	];

	public function curso(): BelongsTo
	{
		return $this->belongsTo(Curso::class);
	}

	public function visivels(): HasMany
	{
		return $this->hasMany(Visivel::class);
	}

	public function duracaos(): HasMany
	{
		return $this->hasMany(Duracao::class);
	}

	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class);
	}
	//TODO: implement current scope
	public function scopeCurrent(Builder $query): Builder
	{
		//
	}

	public function scopeActive(Builder $query): void
	{
		$query->where(self::ATIVO, true);
	}
	

	public function titulo() : string 
	{
		/*
		* Format:
		* Mestrado em Engenharia Informática (Plurianual Fev 2023 - Fev 2024)
		* Mestrado em Engenharia Informática (Set 2023 - Set 2024)
		* Mestrado em Segurança Informática (Set 2023 - Set 2024)
		* Mestrado em Engenharia e Ciência de Dados (Set 2023 - Set 2024)
		* Mestrado em Design e Multimédia (Set 2023 - Set 2024)
		* Degree name + (Plurianual if applicable) + Start year + End year, all in Portuguese. Name of months in short form.
		*/
		$curso = $this->curso;
		$nome_curso = $curso->nome;
		//it's pluriannual if the start and end months are february
		$plurianual = $this->inicio_estagio->month == 2 && $this->fim_estagio->month == 2;
		//using carbon
		$inicio = Carbon::parse($this->inicio_estagio)->translatedFormat('M Y');
		$fim = Carbon::parse($this->fim_estagio)->translatedFormat('M Y');

		$titulo = $nome_curso . ' (' . ($plurianual ? 'Plurianual ' : '') . $inicio . ' - ' . $fim . ')';
		return $titulo;
	}
}
