<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GestorPlataforma
 * 
 * @property string $nao_aluno_utilizador_email
 * 
 * @property NaoAluno $nao_aluno
 *
 * @package App\Models
 */
class GestorPlataforma extends Model
{
	use ModelObservableTrait;
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'gestor_plataforma';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, GestorPlataforma::NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
