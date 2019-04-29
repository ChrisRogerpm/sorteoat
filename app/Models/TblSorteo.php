<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 14 Jan 2019 17:20:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * Class TblSorteo
 * 
 * @property int $id
 * @property \Carbon\Carbon $fecha_registro
 * @property string $nombre_sorteo
 * @property string $descripcion_sorteo
 * @property string $serie_sorteo
 * @property string $rd
 * @property int $estado_sorteo
 * @property \Carbon\Carbon $fecha_operacion
 * @property \Carbon\Carbon $fecha_inicio
 * @property \Carbon\Carbon $fecha_fin
 *
 * @package App\Models
 */
class TblSorteo extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'estado_sorteo' => 'int',
		'iniciado' => 'int'		
	];

	protected $dates = [
		'fecha_registro',
		'fecha_operacion',
		'fecha_inicio',
		'fecha_fin'
	];

	protected $fillable = [
		'fecha_registro',
		'nombre_sorteo',
		'descripcion_sorteo',
		'serie_sorteo',
		'rd',
		'estado_sorteo',
		'iniciado',		
		'fecha_operacion',
		'fecha_inicio',
		'fecha_fin'
	];
	public static function ObtenerActivoSorteoJson()
    {		
		$sorteo = TblSorteo::where('estado_sorteo', '=',1)->first();		       
        return $sorteo;
	}
	public static function ObtenerSorteoJson($id)
    {		
		$sorteo = TblSorteo::where('id', '=',$id)->first();		       
        return $sorteo;
	}
	public static function ObtenerActivoBeneficioSorteoJson()
    {	
		$sorteo =DB::table('tbl_sorteos')
			->select('tbl_sorteos.*','tbl_restricciones.valor_apuesta')
            ->leftJoin('tbl_restricciones', 'tbl_sorteos.id', '=', 'tbl_restricciones.id_sorteo')
			->where('estado_sorteo', '=',1)			
			->first();				
		//$sorteo = TblSorteo::where('estado_sorteo', '=',1)->first();		       
        return $sorteo;
	}
	public static function SorteoActivoValidarJson()
    {
		$esVigente=0;
		$fechaActual=date('Y-m-d H:i:s');
		$sorteo = TblSorteo::where('estado_sorteo', '=',1)->first();
		if(is_null($sorteo)){
			$esVigente=0;
		}			
		else{
			if(($fechaActual>=$sorteo->fecha_inicio)&&($fechaActual<$sorteo->fecha_fin)){
				$esVigente=1;
			}
			else{
				$esVigente=0;
			}
		}        
        return $esVigente;
	}
	public static function SorteoVigenteObtenerJson()
    {
		$esVigente=0;
		$sorteo = TblSorteo::where('estado_sorteo', '=',1)->first();
		if(is_null($sorteo)){
			$esVigente=0;
		}			
		else{
			$esVigente=1;
		}        
        return $esVigente;
	}	
	public static function SorteoInsertarJson(Request $request)
	{		
		$idSorteoInsertado = DB::table('tbl_sorteos')->insertGetId([            
            'fecha_registro' => date('Y-m-d H:i:s'),
            'nombre_sorteo' => $request->txtNombreSorteo,
            'descripcion_sorteo' => $request->txtDescripcionSorteo,
            'rd' => $request->txtRdSorteo,
            'estado_sorteo' => 2,
            'iniciado' => 0,
            'fecha_operacion' => date('Y-m-d H:i:s'),
            'fecha_inicio' =>date('Y-m-d H:i:s',strtotime($request->txtFechaInicio)),
            'fecha_fin' => date('Y-m-d H:i:s',strtotime($request->txtFechaFin)),
		]);  				
        return $idSorteoInsertado;
	}	
	public static function SorteoListarJson()
    {
		//$listar = TblSorteo::all();
		$listar =DB::table('tbl_sorteos')
			->select('tbl_sorteos.*','tbl_restricciones.porRegiones')
            ->leftJoin('tbl_restricciones', 'tbl_sorteos.id', '=', 'tbl_restricciones.id_sorteo')
            ->get();
        return $listar;
	}	
	public static function SorteoActivar()
    { 
		$respuesta=false;
		$fechaActual=date('Y-m-d H:i:s');
		$sorteos = TblSorteo::where('estado_sorteo', '=',2)->get();
		if(is_null($sorteos)){
			$respuesta=false;
		}	
		else{
			foreach ($sorteos as $sorteo) {
				if(($fechaActual>=$sorteo->fecha_inicio)&&($fechaActual<$sorteo->fecha_fin)){
					TblSorteo::where('estado_sorteo', '=',2)->first()->update(['estado_sorteo'=>1]);
					$respuesta=true;
				}
				else{
					$respuesta=false;
				}
			}			
		}			
        return $respuesta;
	}	
	public static function DesactivarSorteoJson()
    { 
		$respuesta=false;
		$fechaActual=date('Y-m-d H:i:s');
		$sorteos = TblSorteo::where('estado_sorteo', '=',1)->get();
		if(is_null($sorteos)){
			$respuesta=false;
		}	
		else{
			foreach ($sorteos as $sorteo) {
				if( $fechaActual>$sorteo->fecha_fin ){
					TblSorteo::where('id', '=',$sorteo->id)->first()->update(['estado_sorteo'=>0]);
					$respuesta=true;
				}
				else{
					$respuesta=false;
				}
			}			
		}			
        return $respuesta;
	}			
	public static function ConsultarIniciadoSorteoJson()
	{		
		//$sorteo = TblSorteo::where('estado_sorteo', '=', 1)->Where('iniciado', '>', 0)->first();
		$sorteo = TblSorteo::Where('iniciado', '>', 0)->first();
		if(is_null($sorteo))
		{
			$respuesta=false;	
		}
		else
		{
			$respuesta=true;	
		}
        return $sorteo;
	}
	public static function IniciarSorteoJson($sorteoId,$beneficioId)
	{		
		TblSorteo::where('id', '=',$sorteoId)->first()->update(['iniciado'=>$beneficioId]);
		$respuesta=true;	
        return $respuesta;
	}
	public static function ObtenerIniciadoSorteoJson()
	{		
		//$sorteo = TblSorteo::where('estado_sorteo', '=', 1)->Where('iniciado', '>', 0)->first();		
		$sorteo = TblSorteo::Where('iniciado', '>', 0)->first();		
        return $sorteo;
	}	
	public static function PararSorteoJson($sorteoId)
	{		
		TblSorteo::where('id', '=',$sorteoId)->first()->update(['iniciado'=>0]);
		$respuesta=true;	
        return $respuesta;
	}		
}
