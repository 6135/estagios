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
 * Class Instituicao
 * 
 * @property int $nome
 * 
 * @property Collection|Externo[] $externos
 *
 * @package App\Models
 */
class Instituicao extends Model
{
	use ModelObservableTrait;
	const NOME = 'nome';
	protected $table = 'instituicao';
	protected $primaryKey = 'nome';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::NOME => 'int'
	];

	public function externos(): HasMany
	{
		return $this->hasMany(Externo::class, Externo::INSTITUICAO_NOME);
	}
}
