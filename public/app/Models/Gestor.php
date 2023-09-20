<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Gestor
 * 
 * @property int $empresa_id
 * @property string $nao_aluno_utilizador_email
 * @property string $cargo
 * 
 * @property Empresa $empresa
 * @property NaoAluno $nao_aluno
 *
 * @package App\Models
 */
class Gestor extends Model
{
	use ModelObservableTrait;
	const EMPRESA_ID = 'empresa_id';
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	const CARGO = 'cargo';
	protected $table = 'gestor';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::EMPRESA_ID => 'int'
	];

	protected $fillable = [
		self::NAO_ALUNO_UTILIZADOR_EMAIL,
		self::EMPRESA_ID,
		self::CARGO
	];

	public function empresa(): BelongsTo
	{
		return $this->belongsTo(Empresa::class);
	}

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Gestor::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

}
