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
 * Class Reuniao
 * 
 * @property Carbon $data
 * @property string $participantes
 * @property string $comentarios
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $proposta_id
 * 
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class Reuniao extends Model
{
	use ModelObservableTrait;
	const DATA = 'data';
	const PARTICIPANTES = 'participantes';
	const COMENTARIOS = 'comentarios';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'reuniao';
	protected $primaryKey = 'data';
	public $incrementing = false;

	protected $casts = [
		self::DATA => 'datetime',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime',
		self::PROPOSTA_ID => 'int'
	];

	protected $fillable = [
		self::PARTICIPANTES,
		self::COMENTARIOS,
		self::PROPOSTA_ID
	];

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
