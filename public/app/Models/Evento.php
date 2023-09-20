<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Evento
 * 
 * @property int $tipo
 * 
 * @property Collection|Duracao[] $duracaos
 *
 * @package App\Models
 */
class Evento extends Model
{
	use ModelObservableTrait;
	const TIPO = 'tipo';
	protected $table = 'evento';
	protected $primaryKey = 'tipo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::TIPO => 'int'
	];

	public function duracaos(): HasMany
	{
		return $this->hasMany(Duracao::class, Duracao::EVENTO_TIPO);
	}
}
