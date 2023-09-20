<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Observers\ModelObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Estado
 * 
 * @property string $nome
 * @property string $descricao
 * @property string $cor
 * 
 * @property Collection|Proposta[] $propostas
 *
 * @package App\Models
 */
class Estado extends Model
{
	use ModelObservableTrait;
	const NOME = 'nome';
	const DESCRICAO = 'descricao';
	const COR = 'cor';
	protected $table = 'estado';
	protected $primaryKey = 'nome';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		self::DESCRICAO,
		self::COR
	];

	const NOVO = 'Novo';
	const AGUARDA_REVISAO_COOR_CURSO = 'Aguarda revisão da coordenação de curso';
	const APROVADO = 'Aprovado';
	const CANCELADO = 'Cancelado';
	const REJEITE = 'Rejeite';
	const REVISTO = 'Revisto';


	const ESTADOS = [
		"1" => array(
			'text' => "Novo",
			'colour' => '#666666',
			'badge' => 'secondary'
		),
		"2" => array(
			'text' => "Aguarda revisão da coordenação de curso",
			'colour' => '#ffc700',
			'badge' => 'warning'
		),
		"3" => array(
			'text' => "Aprovado",
			'colour' => 'green',
			'badge' => 'success'
		),
		"4" => array(
			'text' => "Revisto",
			'colour' => '#35a7e0',
			'badge' => 'success'
		),
		"5" => array(
			'text' => "Rejeitado",
			'colour' => 'red',
			'badge' => 'danger'
		),
		"6" => array(
			'text' => "Cancelado",
			'colour' => '#333333',
			'badge' => 'danger'
		)
	];
	public static function getEstado(int $idEstado)
	{
		$estado = array();
		$estadoestagio = self::ESTADOS;

		if ($idEstado == 0) {
			return $estadoestagio;
		}
		if (in_array($idEstado, array(1, 2, 3, 4, 5, 6)))
			$estado = $estadoestagio[$idEstado];
		else
			$estado = array(
				'text' => 'Erro',
				'colour' => 'red',
				'badge' => 'danger',
			);

		return $estado;
	}

	public function propostas(): HasMany
	{
		return $this->hasMany(Proposta::class, Proposta::ESTADO_NOME);
	}
}