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
 * Class Recetor
 * 
 * @property int $id
 * @property Carbon|null $lida
 * @property int $mensagem_id
 * @property string $utilizador_email
 * 
 * @property Mensagem $mensagem
 * @property Utilizador $utilizador
 *
 * @package App\Models
 */
class Recetor extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const LIDA = 'lida';
	const MENSAGEM_ID = 'mensagem_id';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'recetor';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::LIDA => 'datetime',
		self::MENSAGEM_ID => 'int'
	];

	protected $fillable = [
		self::LIDA,
		self::MENSAGEM_ID,
		self::UTILIZADOR_EMAIL
	];

	public function mensagem(): BelongsTo
	{
		return $this->belongsTo(Mensagem::class);
	}

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, Recetor::UTILIZADOR_EMAIL);
	}
}
