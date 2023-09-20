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
 * Class Visibilidade
 * 
 * @property string $tipo
 * 
 * @property Collection|Visivel[] $visivels
 *
 * @package App\Models
 */
class Visibilidade extends Model
{
	use ModelObservableTrait;
	const TIPO = 'tipo';
	protected $table = 'visibilidade';
	protected $primaryKey = 'tipo';
	public $incrementing = false;
	public $timestamps = false;

	public function visivels(): HasMany
	{
		return $this->hasMany(Visivel::class, Visivel::VISIBILIDADE_TIPO);
	}
}
