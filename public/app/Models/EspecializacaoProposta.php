<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EspecializacaoProposta
 * 
 * @property string $especializacao_nome
 * @property int $proposta_id
 * 
 * @property Especializacao $especializacao
 * @property Proposta $proposta
 *
 * @package App\Models
 */
class EspecializacaoProposta extends Model
{
	use ModelObservableTrait;
	const ESPECIALIZACAO_NOME = 'especializacao_nome';
	const PROPOSTA_ID = 'proposta_id';
	protected $table = 'especializacao_proposta';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		self::PROPOSTA_ID => 'int'
	];

	public function especializacao(): BelongsTo
	{
		return $this->belongsTo(Especializacao::class, EspecializacaoProposta::ESPECIALIZACAO_NOME);
	}

	public function proposta(): BelongsTo
	{
		return $this->belongsTo(Proposta::class);
	}
}
