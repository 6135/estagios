<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Http\Controllers\Auth\Authentication;
use App\Mail\AdditionalDetailsMail;
use App\Mail\ConfirmationMail;
use App\Observers\ModelObservableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


/**
 * Class Utilizador
 * 
 * @property string $email
 * @property string $nome
 * @property string|null $nome_curto
 * @property bool $ativo
 * @property string|null $password_hash
 * @property string|null $confirmacao_hash
 * @property bool $confirmacao
 * @property string|null $ics
 * @property string|null $dados_adicionais_hash
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Mensagem[] $mensagems
 * @property Collection|Recetor[] $recetors
 * @property Collection|AccessLog[] $access_logs
 * @property NaoAluno $nao_aluno
 * @property Aluno $aluno
 * @property Collection|Proposta[] $propostas
 * @property Collection|PapelDoUtilizador[] $papeis
 * 
 *
 * @package App\Models
 */
class Utilizador extends Model
{
	use ModelObservableTrait;
	public $estado;
	const EMAIL = 'email';
	const NOME = 'nome';
	const NOME_CURTO = 'nome_curto';
	const ATIVO = 'ativo';
	const PASSWORD_HASH = 'password_hash';
	const CONFIRMACAO_HASH = 'confirmacao_hash';

	const PASSWORD_RESET_HASH = 'password_reset_hash';
	const CONFIRMACAO = 'confirmacao';
	const ICS = 'ics';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	const ESTADO = 'estado';

	const DADOS_ADICIONAIS_HASH = 'dados_adicionais_hash';
	protected $table = 'utilizador';
	protected $primaryKey = 'email';
	public $incrementing = false;

	protected $casts = [
		self::ATIVO => 'bool',
		self::CONFIRMACAO => 'bool',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $hidden = [
		self::PASSWORD_HASH,
		self::CONFIRMACAO_HASH,
		'pivot',
		self::ICS,
		self::PASSWORD_RESET_HASH,
		self::DADOS_ADICIONAIS_HASH
	];

	protected $fillable = [
		self::EMAIL,
		self::NOME,
		self::NOME_CURTO,
		self::ATIVO,
		self::PASSWORD_HASH,
		self::CONFIRMACAO_HASH,
		self::CONFIRMACAO,
		self::DADOS_ADICIONAIS_HASH,
		self::ICS
	];
	protected $appends = ['estado'];
	public $keyType = 'string';

	public function getShortName(): string
	{
		//if nome_curto is null then get first name and last name from name
		if($this->nome_curto == null){
			$names = explode(' ', $this->nome);
			if(count($names) == 1)
				return $names[0];
			else 
				return $names[0] . ' ' . $names[count($names) - 1];
		} else {
			return $this->nome_curto;
		}
	}

	public function mensagems(): HasMany
	{
		return $this->hasMany(Mensagem::class, Mensagem::UTILIZADOR_EMAIL);
	}

	public function recetors(): HasMany
	{
		return $this->hasMany(Recetor::class, Recetor::UTILIZADOR_EMAIL);
	}

	public function access_logs(): HasMany
	{
		return $this->hasMany(AccessLog::class, AccessLog::UTILIZADOR_EMAIL);
	}

	public function nao_aluno(): HasOne
	{
		return $this->hasOne(NaoAluno::class, NaoAluno::UTILIZADOR_EMAIL);
	}

	public function aluno(): HasOne
	{
		return $this->hasOne(Aluno::class, Aluno::UTILIZADOR_EMAIL);
	}

	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::UTILIZADOR_EMAIL);
	}

	public function papeis(): BelongsToMany
	{
		return $this->belongsToMany(PapelUtilizador::class, 'papel_utilizador_utilizador', PapelDoUtilizador::UTILIZADOR_EMAIL, PapelDoUtilizador::PAPEL_UTILIZADOR_TIPO);
	}

			/**
	 * Scope a query to only include active users.
	 * @param mixed $query
	 */
	public function scopeActive($query): void
	{
		$query->where(self::ATIVO, true);
	}
	
			/**
	 * Scope a query to only include confirmed users.
	 * @param mixed $query
	 */
	public function scopeConfirmed($query): void
	{
		$query->where(self::CONFIRMACAO, true);
	}
	/**
	 * Creates a user from an LDAP entry.
	 * @param $user ldap entry
	 */
	public static function userFromLdap($email, $ldapUser): Utilizador
	{
		$user = new Utilizador();
		$user->email = $email;
		$user->nome = ($ldapUser->cn)[0];
		$user->password_hash = null;
		$user->confirmacao_hash = null;
		$user->confirmacao = true;
		$user->save();
		return $user;
	}

	/**
	 * Check if user has a role
	 */
	public function hasRole($role): bool
	{
		return $this->papeis()->where(PapelUtilizador::TIPO, $role)->exists();
	}

	/**
	 * All roles exept the one passed as parameter
	 */
	public function rolesExcept($role): Collection	
	{
		return $this->papeis()->whereNot(PapelUtilizador::TIPO, $role)->get();
	}

	/**
	 * All roles exept the ones passed as parameters
	 */
	public function rolesExceptArray($roles): Collection
	{
		return $this->papeis()->whereNotIn(PapelUtilizador::TIPO, $roles)->get();
	}
	/**
	 * Assign a papel to a user, if it doesnt have it
	 */
	public function assignRole($role): bool
	{
		$roleObj = PapelUtilizador::where(PapelUtilizador::TIPO, $role)->first();
		if (!$this->hasRole($role) && $roleObj) {
			$this->papeis()->attach(PapelUtilizador::where(PapelUtilizador::TIPO, $role)->first());
			return true;
		}
		return false;
	}


	/*
	 * Gets docente object through the nao_aluno object as if it was a relationship
	 */
	public function docente(): Docente
	{
		return $this->nao_aluno->docente;
	}


	/*
	 * Gets Gestor object through the nao_aluno object as if it was a relationship
	 */
	public function gestor(): Gestor
	{
		return $this->nao_aluno->gestor;
	}

	/**
	 * retuns bool if user is active and confirmed
	 */
	public function isActiveAndConfirmed(): bool
	{
		return $this->ativo && $this->confirmacao;
	}
	
	public function estado(): Attribute
	{
		$string = '';
		if ($this->ativo && $this->confirmacao) {
			$string = __('words.active');
		} else if ($this->ativo && !$this->confirmacao) {
			$string = __('words.not_confirmed');
		} else //if (!$this->ativo) {
			$string = __('words.inactive');
		//} else {
		//	$string = __('words.inactive_and_not_confirmed');
		//}
		return new Attribute(
			get: fn() => $string,
		);
	}

	/**
	 * Sends an email to the user to fill in his data for added roles
	 */
	public function sendEmailToFillInData(array $types, Utilizador $user): void
	{
		$typesJSON = json_encode($types);
		$user->dados_adicionais_hash = base64_encode(Str::random(256) . ':::' . $typesJSON );
		$user->save();
        $message = new Mensagem();
        $message->assunto = __('static.emails.details..subject');
        $message->mensagem = __('static.emails.details.body')." Link: ". route('details.email', $user->dados_adicionais_hash);
        $message->enviada = Carbon::now();
        $message->save();
        $url = route('details.email', $user->dados_adicionais_hash);

        $recetor = new Recetor();
        $recetor->mensagem_id = $message->id;
        $recetor->utilizador_email = $user->email;

        Mail::to($user->email)->queue(new AdditionalDetailsMail($url));
	}
}
