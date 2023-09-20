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
 * Class PapelJuri
 * 
 * @property string $funcao
 * 
 * @property Collection|Juri[] $juris
 *
 * @package App\Models
 */
class PapelJuri extends Model
{
	use ModelObservableTrait;
	const FUNCAO = 'funcao';
	protected $table = 'papel_juri';
	protected $primaryKey = 'funcao';
	public $incrementing = false;
	public $timestamps = false;

	public function juris(): HasMany
	{
		return $this->hasMany(Juri::class, Juri::PAPEL_JURI_FUNCAO);
	}
}
