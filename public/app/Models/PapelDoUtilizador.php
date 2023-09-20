<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PapelDoUtilizador
 * 
 * @property string $papel_utilizador_tipo
 * @property string $utilizador_email
 * 
 * @property PapelUtilizador $papel_utilizador
 * @property Utilizador $utilizador
 *
 * @package App\Models
 */
class PapelDoUtilizador extends Model
{
	use ModelObservableTrait;
	const PAPEL_UTILIZADOR_TIPO = 'papel_utilizador_tipo';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'papel_utilizador_utilizador';
	public $incrementing = false;
	public $timestamps = false;

	public function papel_utilizador(): BelongsTo
	{
		return $this->belongsTo(PapelUtilizador::class, PapelDoUtilizador::PAPEL_UTILIZADOR_TIPO);
	}

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, PapelDoUtilizador::UTILIZADOR_EMAIL);
	}
}
