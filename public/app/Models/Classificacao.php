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
 * Class Classificacao
 * 
 * @property string $designacao
 * 
 * @property Collection|Defesaintermedia[] $defesaintermedia
 *
 * @package App\Models
 */
class Classificacao extends Model
{
	use ModelObservableTrait;
	const DESIGNACAO = 'designacao';
	protected $table = 'classificacao';
	protected $primaryKey = 'designacao';
	public $incrementing = false;
	public $timestamps = false;

	public function defesaintermedia(): HasMany
	{
		return $this->hasMany(Defesaintermedia::class, Defesaintermedia::CLASSIFICACAO_DESIGNACAO);
	}
}
