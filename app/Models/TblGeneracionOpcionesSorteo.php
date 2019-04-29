<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * Class TblGeneracionOpcionesSorteo
 * 
 * @property int $id
 * @property int $id_cliente
 * @property int $id_sorteo
 * @property string $ticket_id
 * @property string $unit_id
 * @property string $local
 * @property \Carbon\Carbon $time_played
 * @property string $event_id
 * @property string $game
 * @property float $stake_amount
 * @property string $currency
 * @property string $ticket_status
 * @property int $winning_amount
 * @property float $jackpot
 * @property string $result
 * @property int $cantidad_opciones
 * @property \Carbon\Carbon $fecha_registro
 * @property int $id_tienda
 * @property \Carbon\Carbon $paid_out_time
 * @property int $serie_inicio
 * @property int $serie_fin
 *
 * @package App\Models
 */
class TblGeneracionOpcionesSorteo extends Eloquent
{
	protected $table = 'tbl_generacion_opciones_sorteo';
	public $timestamps = false;

	protected $casts = [
		'id_cliente' => 'int',
		'id_sorteo' => 'int',
		'stake_amount' => 'float',
		'winning_amount' => 'int',
		'jackpot' => 'float',
		'cantidad_opciones' => 'int',
		'id_tienda' => 'int',
		'serie_inicio' => 'int',
		'serie_fin' => 'int'
	];

	protected $dates = [
		'time_played',
		'fecha_registro',
		'paid_out_time'
	];

	protected $fillable = [
		'id_cliente',
		'id_sorteo',
		'ticket_id',
		'unit_id',
		'local',
		'time_played',
		'event_id',
		'game',
		'stake_amount',
		'currency',
		'ticket_status',
		'winning_amount',
		'jackpot',
		'result',
		'cantidad_opciones',
		'fecha_registro',
		'id_tienda',
		'paid_out_time',
		'serie_inicio',
		'serie_fin'
	];
	public static function GeneracionOpcionesSorteoBuscar($ticket)
	{
		$ticketBD =  DB::table('tbl_generacion_opciones_sorteo')->where('ticket_id', $ticket)->first(); 
		return $ticketBD;
	}
	public static function GeneracionOpcionSorteoInsertar($ticket)
	{
		DB::table('tbl_generacion_opciones_sorteo')->insertGetId(
			[
                'id_cliente' => $ticket->idCliente,
                'id_sorteo'=>$ticket->id_sorteo,
                'ticket_id'=>$ticket->ticket_id,
                'unit_id'=>$ticket->unit_id,
                'local'=>$ticket->local,
                'time_played'=> date('Y-m-d', $ticket->time_played),
                'event_id'=>$ticket->event_id,
                'game'=>$ticket->game,
                'stake_amount'=>$ticket->stake_amount,
                'currency'=>$ticket->currency,
                'ticket_status'=>$ticket->ticket_status,
                'winning_amount'=>$ticket->winning_amount,
                'jackpot'=>$ticket->jackpot,
                'result'=>$ticket->result,
                'cantidad_opciones'=>$ticket->oportunidades,
                'fecha_registro'=>$ticket->fecha_registro,
                'id_tienda'=>$ticket->id_tienda,
				'paid_out_time'=>$ticket->paid_out_time,
				
				// 'id_cliente' => 1,
                // 'id_sorteo'=>1,
                // 'ticket_id'=>'1',
                // 'unit_id'=>'1',
                // 'local'=>'1',
                // 'time_played'=> date('Y-m-d'),
                // 'event_id'=>'1',
                // 'game'=>'1',
                // 'stake_amount'=>1,
                // 'currency'=>'1',
                // 'ticket_status'=>'$ticket->ticket_status',
                // 'winning_amount'=>1,
                // 'jackpot'=>1,
                // 'result'=>'$ticket->result',
                // 'cantidad_opciones'=>1,
                // 'fecha_registro'=>date('Y-m-d'),
                // 'id_tienda'=>1,
                // 'paid_out_time'=>date('Y-m-d'),
            ]
        );
	}
	public static function ObtenerGanadorGeneracionOpcionesSorteo()
	{
		$ganador=0;
		$ultimo=DB::table('tbl_generacion_opciones_sorteo')->orderBy('id', 'desc')->first();
		$ganador =rand(1, $ultimo->serie_fin);
		return $ganador;
	}	
	public static function ReporteOpcionesSorteosListarJson(Request $request)
	{	$listar=[];
		$txtFechaInicio = $request->txtFechaInicio;
		$txtFechaFin = $request->txtFechaFin;
		$arrLocales = $request->arrLocales;
		$arrJuegos = $request->arrJuegos;

		$arrLocales = is_array($arrLocales) ? implode(",", $arrLocales) : $arrLocales;

        //$where ="where pv.idPuntoVenta in (".$tiendas.") and";
		//$where = ($arrLocales[0]=="0") ? "" : "where pv.idPuntoVenta in (".$arrLocales.")" ;
		// FROM  tbl_generacion_opciones_sorteo as gos
		// INNER JOIN tbl_clientes c ON c.ID = gos.id_cliente
		// tbl_clientes as c
		// tbl_clientes as c', 'c.ID','gos.id_cliente'
		if($request->arrLocales[0]=='0' && $request->arrJuegos[0]=='0')
		{
			$listar = DB::table('tbl_generacion_opciones_sorteo as gos') 
				->join('tbl_clientes as c', 'c.ID','gos.id_cliente')
				
				//INNER JOIN tbl_consolidado_opciones_sorteo tcos ON tcos.id_cliente= c.ID
				//INNER JOIN tbl_generacion_opciones_sorteo as gos ON gos.id_cliente = c.ID
				->whereBetween('gos.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
				->get();					
		}
		else
		{
			if($request->arrLocales[0]!='0' && $request->arrJuegos[0]!='0')
			{
				$listar = DB::table('tbl_generacion_opciones_sorteo as gos') 
				->join('tbl_clientes as c', 'c.ID','gos.id_cliente')
				->join('tbl_generacion_opciones_sorteo as gos', 'gos.id_cliente','c.ID')
				
				->whereIn('local', $request->arrLocales)
				->whereIn('game', $request->arrJuegos)
				
				->whereBetween('gos.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
				->get();
			}
			else
			{
				if($request->arrLocales[0]=='0')
				{
					$listar = DB::table('tbl_generacion_opciones_sorteo as gos') 
					->join('tbl_clientes as c', 'c.ID','gos.id_cliente')
					->join('tbl_generacion_opciones_sorteo as gos', 'gos.id_cliente','c.ID')
					->whereIn('game', $request->arrJuegos)
					->whereBetween('gos.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
					->get();
				}
				if($request->arrJuegos[0]=='0')
				{
					$listar = DB::table('tbl_generacion_opciones_sorteo as gos') 
					->join('tbl_clientes as c', 'c.ID','gos.id_cliente')
					->join('tbl_generacion_opciones_sorteo as gos', 'gos.id_cliente','c.ID')
					->whereIn('local', $request->arrLocales)
					->whereBetween('gos.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
					->get();
				}
			}							
		}							
		return $listar;
	}
	public static function ObtenerGanadorOpcionesSorteosJson($idGanador)
	{
		$ganador = DB::table('tbl_generacion_opciones_sorteo')
		->where('serie_inicio', '<=', $idGanador)
		->where('serie_fin', '>=', $idGanador)
		->first();		
        return $ganador;
	}	
}