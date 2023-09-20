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
 * Class Documento
 * 
 * @property string $tipo
 * 
 * @property Collection|Aluno[] $alunos
 *
 * @package App\Models
 */
class Documento extends Model
{
	use ModelObservableTrait;
	const TIPO = 'tipo';
	protected $table = 'documento';
	protected $primaryKey = 'tipo';
	public $incrementing = false;
	public $timestamps = false;

	public function alunos(): HasMany
	{
		return $this->hasMany(Aluno::class, Aluno::DOCUMENTO_TIPO);
	}
}
