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
 * Class Defesafinal
 * 
 * @property string|null $relatorio
 * @property string|null $anexos
 * @property Carbon|null $data
 * @property int|null $avaliacao
 * @property string|null $comentarios
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $proposta_id
 * 
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class Defesafinal extends Model
{
	use ModelObservableTrait;
	const RELATORIO = 'relatorio';
	const ANEXOS = 'anexos';
	const DATA = 'data';
	const AVALIACAO = 'avaliacao';
	const COMENTARIOS = 'comentarios';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'defesafinal';
	protected $primaryKey = 'proposta_id';
	public $incrementing = false;

	protected $casts = [
		self::DATA => 'datetime',
		self::AVALIACAO => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::RELATORIO,
		self::ANEXOS,
		self::DATA,
		self::AVALIACAO,
		self::COMENTARIOS
	];

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
