<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Helpers\CantorPairing;
use App\Observers\ModelObservableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Proposta
 * 
 * @property int $id
 * @property string $codigo_proposta
 * @property string $titulo
 * @property string $enquadramento
 * @property string $objetivos
 * @property string $plano1
 * @property string $plano2
 * @property string|null $condicoes
 * @property string|null $observacoes
 * @property bool $deseja_entrevistas
 * @property Carbon $created_at
 * @property string|null $utilizador_email //aluno indicado
 * @property string $nao_aluno_utilizador_email //criador da proposta
 * @property string|null $representante_nao_aluno_utilizador_email //representante da empresa
 * @property string|null $identificacao_aluno_utilizador_email //aluno colocado
 * @property int|null $proposta_pai
 * @property int $edicao_estagio_id
 * @property string $estado_nome
 * 
 * @property Utilizador|null $utilizador
 * @property Collection|NaoAluno[] $colaboradores
 * @property Representante|null $representante
 * @property Aluno|null $aluno
 * @property Proposta|null $proposta
 * @property EdicaoEstagio $edicao_estagio
 * @property Estado $estado
 * @property Collection|Candidatura[] $candidaturas
 * @property Defesaintermedia $defesaintermedia
 * @property Defesafinal $defesafinal
 * @property Collection|Reuniao[] $reuniaos
 * @property Collection|Juri[] $juris
 * @property Collection|Revisao[] $revisoes
 * @property Collection|Proposta[] $versoes
 * @property Proposta $original
 * @property Collection|Proposta[] $propostas
 * @property Collection|Especializacao[] $especializacao
 *
 * @package App\Models
 */
class Proposta extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const CODIGO_PROPOSTA = "codigo_proposta";
	const VERSAO = "versao";
	const TITULO = 'titulo';
	const ENQUADRAMENTO = 'enquadramento';
	const OBJETIVOS = 'objetivos';
	const PLANO1 = 'plano1';
	const PLANO2 = 'plano2';
	const CONDICOES = 'condicoes';
	const OBSERVACOES = 'observacoes';
	const DESEJA_ENTREVISTAS = 'deseja_entrevistas';
	const CREATED_AT = 'created_at';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	const REPRESENTANTE_NAO_ALUNO_UTILIZADOR_EMAIL = 'representante_nao_aluno_utilizador_email';
	const IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL = 'identificacao_aluno_utilizador_email';
	const PROPOSTA_PAI = 'proposta_pai';
	const EDICAO_ESTAGIO_ID = 'edicao_estagio_id';
	const ESTADO_NOME = 'estado_nome';
	protected $table = 'proposta';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DESEJA_ENTREVISTAS => 'bool',
		self::CREATED_AT => 'datetime',
		self::PROPOSTA_PAI => 'int',
		self::EDICAO_ESTAGIO_ID => 'int'
	];

	protected $fillable = [
		self::TITULO,
		self::VERSAO,
		self::CODIGO_PROPOSTA,
		self::ENQUADRAMENTO,
		self::OBJETIVOS,
		self::PLANO1,
		self::PLANO2,
		self::CONDICOES,
		self::OBSERVACOES,
		self::DESEJA_ENTREVISTAS,
		self::UTILIZADOR_EMAIL,
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::REPRESENTANTE_NAO_ALUNO_UTILIZADOR_EMAIL,
		self::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL,
		self::PROPOSTA_PAI,
		self::EDICAO_ESTAGIO_ID,
		self::ESTADO_NOME
	];

	/**
	 * define codigo_proposta as a result of the Cantor pairing function of the id and father id
	 */
	public static function booted()
	{
		self::creating(function ($model){
			$model->created_at = $model->freshTimestamp();
		});
		self::created(function ($model) {
			
			if($model->codigo_proposta == null){
				$model->codigo_proposta = CantorPairing::cantor_pair_calculate($model->id, $model->proposta_pai ?? 0);
				$model->save();
			}

		});
		//when saving
		self::saved(function ($model) {
			if($model->codigo_proposta == null){
				$model->codigo_proposta = CantorPairing::cantor_pair_calculate($model->id, $model->proposta_pai ?? 0);
				$model->save();
			}
		});
	}

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, Proposta::UTILIZADOR_EMAIL);
	}

	public function colaboradores(): BelongsToMany
	{
		return $this->belongsToMany(NaoAluno::class, 'nao_aluno_proposta', NaoAlunoProposta::PROPOSTA_ID, NaoAlunoProposta::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function representante(): BelongsTo
	{
		return $this->belongsTo(Representante::class, Proposta::REPRESENTANTE_NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function aluno(): BelongsTo
	{
		return $this->belongsTo(Aluno::class, Proposta::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class, Proposta::PROPOSTA_PAI, Proposta::ID);
	}

	public function edicao_estagio(): BelongsTo
	{
		return $this->belongsTo(EdicaoEstagio::class);
	}

	public function estado(): BelongsTo
	{
		return $this->belongsTo(Estado::class, Proposta::ESTADO_NOME);
	}

	public function candidaturas(): HasMany
	{
		return $this->hasMany(Candidatura::class);
	}

	public function defesaintermedia(): HasOne
	{
		return $this->hasOne(Defesaintermedia::class);
	}

	public function defesafinal(): HasOne
	{
		return $this->hasOne(Defesafinal::class);
	}

	public function reuniaos(): HasMany
	{
		return $this->hasMany(Reuniao::class);
	}

	public function juris(): HasMany
	{
		return $this->hasMany(Juri::class);
	}

	public function revisoes(): HasMany
	{
		return $this->hasMany(Revisao::class);
	}

	/**
	 * One proposal can have many proposal version and one version can only have one proposal
	 */
	public function versoes(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::VERSAO);
	}

	/**
	 * One proposal can have only one original proposal and one original proposal can have many proposal versions
	 */
	public function original(): BelongsTo
	{
		return $this->belongsTo(Proposta::class, Proposta::VERSAO, Proposta::ID);
	}
	
	/***
	 * Father has many sons
	 */
	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::PROPOSTA_PAI);
	}

	public function especializacao(): BelongsToMany
	{
		return $this->belongsToMany(Especializacao::class, 'especializacao_proposta', EspecializacaoProposta::PROPOSTA_ID, EspecializacaoProposta::ESPECIALIZACAO_NOME);
	}

	public function  criador(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Proposta::NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
