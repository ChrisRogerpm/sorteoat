<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class TblGanador
 * 
 * @property int $id
 * @property int $id_beneficio
 * @property int $id_cliente
 * @property int $id_usuario
 * @property \Carbon\Carbon $fecha_registro
 * @property \Carbon\Carbon $fecha_modificacion
 *
 * @package App\Models
 */
class TblGanador extends Eloquent
{
	protected $table = 'tbl_ganador';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'id_beneficio' => 'int',
		'id_cliente' => 'int',
		'id_usuario' => 'int',
		'numeroGanador' => 'int'
	];

	protected $dates = [
		'fecha_registro',
		'fecha_modificacion'
	];

	protected $fillable = [
		'id_beneficio',
		'id_cliente',
		'id_usuario',
		'numeroGanador',
		'fecha_registro',
		'fecha_modificacion'
	];
	public static function InsertarGanadorJson($sorteo,$numeroGanador,$cliente)
	{
		DB::table('tbl_ganador')->insertGetId([            
			'id_beneficio' => $sorteo->iniciado,
			'id_cliente' => $cliente,
			'numeroGanador' => $numeroGanador,
			'id_usuario' => session()->get('usuarioID'),                    
			'fecha_registro' => date('Y-m-d'),
		]); 
		return true;
	}
	public static function ObtenerGanadorJson($beneficioId,$numeroGanador)
	{
		$ganador=DB::table('tbl_ganador')->where([['id_beneficio','=',$beneficioId],['numeroGanador','=',$numeroGanador]])->first();	
        return $ganador;  
	}
	public static function ListarGanadorJson(Request $request)
	{
		if ($request->arrSorteos[0]=='0') {
			$ganadores=DB::table('tbl_ganador')
			->select('tbl_ganador.*','tbl_beneficios.premio','tbl_clientes.nombre','tbl_clientes.apellidoPaterno','tbl_clientes.apellidoMaterno','tbl_sorteos.nombre_sorteo')
			->leftJoin('tbl_beneficios', 'tbl_beneficios.id', '=', 'tbl_ganador.id_beneficio')
			->leftJoin('tbl_sorteos', 'tbl_sorteos.id', '=', 'tbl_beneficios.id_sorteo')
			->leftJoin('tbl_clientes', 'tbl_clientes.ID', '=', 'tbl_ganador.id_cliente')
			->get();
		}else{
			$ganadores=DB::table('tbl_ganador')
			->select('tbl_ganador.*','tbl_beneficios.premio','tbl_clientes.nombre','tbl_clientes.apellidoPaterno','tbl_clientes.apellidoMaterno','tbl_sorteos.nombre_sorteo')
			->leftJoin('tbl_beneficios', 'tbl_beneficios.id', '=', 'tbl_ganador.id_beneficio')
			->leftJoin('tbl_sorteos', 'tbl_sorteos.id', '=', 'tbl_beneficios.id_sorteo')
			->leftJoin('tbl_clientes', 'tbl_clientes.ID', '=', 'tbl_ganador.id_cliente')
			->whereIn('tbl_beneficios.id_sorteo',$request->arrSorteos)->get();	
		}				
        return $ganadores;  
	}	
}
