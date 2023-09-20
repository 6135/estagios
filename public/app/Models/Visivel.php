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
 * Class Visivel
 * 
 * @property int $id
 * @property Carbon $data
 * @property bool $aluno
 * @property bool $nao_aluno
 * @property string $visibilidade_tipo
 * @property int $edicao_estagio_id
 * 
 * @property Visibilidade $visibilidade
 * @property EdicaoEstagio $edicao_estagio
 *
 * @package App\Models
 */
class Visivel extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const DATA = 'data';
	const ALUNO = 'aluno';
	const NAO_ALUNO = 'nao_aluno';
	const VISIBILIDADE_TIPO = 'visibilidade_tipo';
	const EDICAO_ESTAGIO_ID = 'edicao_estagio_id';
	protected $table = 'visivel';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DATA => 'datetime',
		self::ALUNO => 'bool',
		self::NAO_ALUNO => 'bool',
		self::EDICAO_ESTAGIO_ID => 'int'
	];

	protected $fillable = [
		self::DATA,
		self::ALUNO,
		self::NAO_ALUNO,
		self::VISIBILIDADE_TIPO,
		self::EDICAO_ESTAGIO_ID
	];

	public function visibilidade(): BelongsTo
	{
		return $this->belongsTo(Visibilidade::class, Visivel::VISIBILIDADE_TIPO);
	}

	public function edicao_estagio(): BelongsTo
	{
		return $this->belongsTo(EdicaoEstagio::class);
	}
}
