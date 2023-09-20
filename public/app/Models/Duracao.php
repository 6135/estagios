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
 * Class Duracao
 * 
 * @property int $id
 * @property Carbon $inicio
 * @property Carbon $fim
 * @property int $edicao_estagio_id
 * @property int $evento_tipo
 * 
 * @property EdicaoEstagio $edicao_estagio
 * @property Evento $evento
 *
 * @package App\Models
 */
class Duracao extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const INICIO = 'inicio';
	const FIM = 'fim';
	const EDICAO_ESTAGIO_ID = 'edicao_estagio_id';
	const EVENTO_TIPO = 'evento_tipo';
	protected $table = 'duracao';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::INICIO => 'datetime',
		self::FIM => 'datetime',
		self::EDICAO_ESTAGIO_ID => 'int',
		self::EVENTO_TIPO => 'int'
	];

	protected $fillable = [
		self::INICIO,
		self::FIM,
		self::EDICAO_ESTAGIO_ID,
		self::EVENTO_TIPO
	];

	public function edicao_estagio(): BelongsTo
	{
		return $this->belongsTo(EdicaoEstagio::class);
	}

	public function evento(): BelongsTo
	{
		return $this->belongsTo(Evento::class, Duracao::EVENTO_TIPO);
	}
}
