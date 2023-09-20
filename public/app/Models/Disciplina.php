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
 * Class Disciplina
 * 
 * @property int $id
 * @property string|null $nome
 * @property Carbon|null $data
 * @property int $curso_id
 * 
 * @property Curso $curso
 *
 * @package App\Models
 */
class Disciplina extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const NOME = 'nome';
	const DATA = 'data';
	const CURSO_ID = 'curso_id';
	protected $table = 'disciplina';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DATA => 'datetime',
		self::CURSO_ID => 'int'
	];

	protected $fillable = [
		self::NOME,
		self::DATA,
		self::CURSO_ID
	];

	public function curso(): BelongsTo
	{
		return $this->belongsTo(Curso::class);
	}
}
