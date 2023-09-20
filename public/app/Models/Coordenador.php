<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Coordenador
 * 
 * @property string $nao_aluno_utilizador_email
 * 
 * @property NaoAluno $nao_aluno
 * @property Collection|Coordenar[] $coordenars
 * @property Collection|Revisao[] $revisaos
 *
 * @package App\Models
 */
class Coordenador extends Model
{
	use ModelObservableTrait;
	const NAO_ALUNO_UTILIZADOR_EMAIL = 'nao_aluno_utilizador_email';
	protected $table = 'coordenador';
	protected $primaryKey = 'nao_aluno_utilizador_email';
	public $incrementing = false;
	public $timestamps = false;

	public function nao_aluno(): BelongsTo
	{
		return $this->belongsTo(NaoAluno::class, Coordenador::NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function coordenars(): HasMany
	{
		return $this->hasMany(Coordenar::class, Coordenar::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL);
	}

	public function revisaos(): HasMany
	{
		return $this->hasMany(Revisao::class, Revisao::COORDENADOR_NAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
