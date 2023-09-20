<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Mensagem
 * 
 * @property int $id
 * @property string $assunto
 * @property string $mensagem
 * @property Carbon $enviada
 * @property string $utilizador_email
 * 
 * @property Utilizador $utilizador
 * @property Collection|Recetor[] $recetors
 *
 * @package App\Models
 */
class Mensagem extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const ASSUNTO = 'assunto';
	const MENSAGEM = 'mensagem';
	const ENVIADA = 'enviada';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'mensagem';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::ENVIADA => 'datetime'
	];

	protected $fillable = [
		self::ASSUNTO,
		self::MENSAGEM,
		self::ENVIADA,
		self::UTILIZADOR_EMAIL
	];

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, Mensagem::UTILIZADOR_EMAIL);
	}

	public function recetors(): HasMany
	{
		return $this->hasMany(Recetor::class);
	}
}
