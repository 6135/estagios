<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Cadeira
 * 
 * @property string $designacao
 * 
 * @property Collection|Aluno[] $identificacao_aluno
 *
 * @package App\Models
 */
class Cadeira extends Model
{
	use ModelObservableTrait;
	const DESIGNACAO = 'designacao';
	protected $table = 'cadeira';
	protected $primaryKey = 'designacao';
	public $incrementing = false;
	public $timestamps = false;

	public function identificacao_aluno(): BelongsToMany
	{
		return $this->belongsToMany(Aluno::class, 'identificacao_aluno_cadeira', AlunoCadeira::CADEIRA_DESIGNACAO, AlunoCadeira::IDENTIFICACAO_ALUNO_UTILIZADOR_EMAIL);
	}
}
