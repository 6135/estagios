<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Countries;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Io238\ISOCountries\Models\Country;

/**
 * Class Pais
 * 
 * @property string $nome
 * @property string $codigo_iso
 * @property string $codigo_tel
 * 
 * @property Collection|Empresa[] $empresas
 * @property Collection|Aluno[] $alunos
 *
 * @package App\Models
 */
class Pais extends Model
{
	use ModelObservableTrait;
	// const NOME = 'nome';

	const CODIGO_ISO = 'codigo_iso';
	const CODIGO_TEL = 'codigo_tel';
	protected $table = 'pais';
	protected $primaryKey = 'codigo_iso';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		self::CODIGO_ISO,
		self::CODIGO_TEL
	];

	protected $appends = [
		'nome'
	];

	public function empresas(): HasMany
	{
		return $this->hasMany(Empresa::class, Empresa::PAIS_CODIGO_ISO);
	}

	public function alunos(): HasMany
	{
		return $this->hasMany(Aluno::class, Aluno::PAIS_CODIGO_ISO);
	}

	public function getNomeAttribute(): string
	{
		return Countries::getOne($this->codigo_iso, app()->currentLocale());
	}

	/*
	* Return a list of countries, their ISO code and their phone code as well as their name in the current locale
	* @return array country list
	*/
	public static function getCountries(): array
	{
		$countries = self::all();
		$countryList = [];
		foreach ($countries as $value) {
			$countryList[] = [
				'nome' => Country::find($value->codigo_iso)->name,
				'codigo_iso' => $value->codigo_iso,
				'codigo_tel' => $value->codigo_tel
			];
		}
		return $countryList;
	}
}