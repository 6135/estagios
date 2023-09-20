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
 * Class AccessLog
 * 
 * @property int $id
 * @property string|null $ipaddr
 * @property string $status
 * @property string $acao
 * @property string|null $detalhes
 * @property Carbon $data
 * @property string|null $utilizador_email
 * 
 * @property Utilizador|null $utilizador
 *
 * @package App\Models
 */
class AccessLog extends Model
{
	use ModelObservableTrait;
	const ID = 'id';
	const IPADDR = 'ipaddr';
	const STATUS = 'status';
	const ACAO = 'acao';
	const DETALHES = 'detalhes';
	const DATA = 'data';
	const UTILIZADOR_EMAIL = 'utilizador_email';
	protected $table = 'log';
	public $timestamps = false;

	protected $casts = [
		self::ID => 'int',
		self::DATA => 'datetime'
	];

	protected $fillable = [
		self::IPADDR,
		self::STATUS,
		self::ACAO,
		self::DETALHES,
		self::DATA,
		self::UTILIZADOR_EMAIL
	];

	public function utilizador(): BelongsTo
	{
		return $this->belongsTo(Utilizador::class, AccessLog::UTILIZADOR_EMAIL);
	}

		/**
	 * Generates a new access log entry for a failed login. Based on the initial access log entry.
	 * @param string $reason
	 * @return AccessLog
	 */
	public function failedLogin(string $reason = '', string $email = ''): AccessLog
	{
		$al = new AccessLog([
			AccessLog::IPADDR => $this->ipaddr,
			AccessLog::STATUS => 'FAILED',
			AccessLog::ACAO => 'LOGIN',
			AccessLog::DETALHES => 'User failed to login with username: ' . $email . ' and ip: ' . $this->ipaddr . '. Because: ' . $reason,
			AccessLog::DATA => Carbon::now()
		]);
		$al->save();
		return $al;
	}

	/**
	 * Generates a new access log entry for a successful login. Based on the initial access log entry.
	 * @return AccessLog
	 */
	public function successfulLogin($user): AccessLog
	{
		$al = new AccessLog([
			AccessLog::IPADDR => $this->ipaddr,
			AccessLog::STATUS => 'SUCCESS',
			AccessLog::ACAO => 'LOGIN',
			AccessLog::DETALHES => 'User logged in with username: ' . $user->email . ' and ip: ' . $this->ipaddr,
			AccessLog::DATA => Carbon::now(),
			AccessLog::UTILIZADOR_EMAIL => $user->email
		]);
		$al->save();
		return $al;
	}

	/**
	 * Updates the access log table with the logout time. Based on the initial access log entry.
	 */
	public function logout(): AccessLog
	{
		$al = new AccessLog([
			AccessLog::IPADDR => $this->ipaddr,
			AccessLog::STATUS => 'SUCCESS',
			AccessLog::ACAO => 'LOGOUT',
			AccessLog::DETALHES => 'User ended session with username: ' . $this->utilizador->email . ' and ip: ' . $this->ipaddr,
			AccessLog::DATA => Carbon::now(),
			AccessLog::UTILIZADOR_EMAIL => session()->has('user') ? session()->get('user')->email : null
		]);
		$al->save();
		return $al;
	}


	/**
	 * New entry from middleware based on result from controller
	 */
	public function routeAccess(string $status, string $acao, string $detalhes): AccessLog
	{
		$al = new AccessLog([
			AccessLog::IPADDR => $this->ipaddr,
			AccessLog::STATUS => $status,
			AccessLog::ACAO => $acao,
			AccessLog::DETALHES => $detalhes,
			AccessLog::DATA => Carbon::now(),
			AccessLog::UTILIZADOR_EMAIL => session()->has('user') ? session()->get('user')->email : null
		]);
		$al->save();
		return $al;

	}
}
