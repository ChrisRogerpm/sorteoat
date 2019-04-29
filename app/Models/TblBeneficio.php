<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:36 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * Class TblBeneficio
 * 
 * @property int $id
 * @property int $id_sorteo
 * @property int $id_tipo_beneficio
 * @property string $premio
 * @property int $numero_ganador
 *
 * @package App\Models
 */
class TblBeneficio extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'id_sorteo' => 'int',
		'id_tipo_beneficio' => 'int',
		'numero_ganador' => 'int',
		'region' => 'int'	
	];

	protected $fillable = [
		'id_sorteo',
		'id_tipo_beneficio',
		'premio',
		'numero_ganador',
		'region'
	];	
	public static function ObtenerBeneficioJson($beneficioId){
		$beneficio=DB::table('tbl_beneficios')->where('id','=',$beneficioId)->first();
		return $beneficio;
	}
	public static function BeneficioInsertarJson($beneficio,$idSorteoInsertado,$i){
		DB::table('tbl_beneficios')->insertGetId([            
			'id_sorteo' => $idSorteoInsertado,
			'id_tipo_beneficio' => (int)$beneficio['tipoBeneficioId'],
			'premio' => $beneficio['beneficioDescripcion'],                    
			'numero_ganador' => 0,
			'region' => $i,
		]); 
		return true;
	}
	public static function ListadoBeneficioJson($sorteoId){
		$arr_beneficio = DB::table('tbl_beneficios')->select('id', 'premio')->where('id_sorteo','=',$sorteoId)->get();		
		return $arr_beneficio;
	}	
	public static function ActualizarBeneficioJson($ganador,$beneficioId){
		DB::table('tbl_beneficios')->where('id','=',$beneficioId)->update(['numero_ganador' => $ganador]);		
		return true;
	}		
	public static function ObtenerNumeroGanadorBeneficioJson($beneficioId){
		$beneficio=DB::table('tbl_beneficios')->where('id','=',$beneficioId)->first();		
		return $beneficio;
	}	
}
