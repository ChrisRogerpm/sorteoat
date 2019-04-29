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

class TblDetalleTicketAgrupado extends Eloquent
{
	public $timestamps = false;
		
	public static function InsertarDetalleTicketAgrupadoJson($id,$id_ticket){
		DB::table('tbl_detalle_ticket_agrupado')->insert([            
			'id_ticket' => $id_ticket,
			'id_ticket_agrupado' => $id,
			'fecha_registro' => date('Y-m-d H:i:s')		
		]); 
		return true;
	}	
	public static function ListarDetalleTicketAgrupadoJson($id_ticket_agrupado){
		$lista=DB::table('tbl_detalle_ticket_agrupado')->where([['id_ticket_agrupado','=',$id_ticket_agrupado]])->get(); 
		return $lista;
	}	
	public static function ObtenerDetalleTicketAgrupadoJson($id_ticket){
		$TicketArupado=DB::table('tbl_detalle_ticket_agrupado')->where([['id_ticket','=',$id_ticket]])->first(); 
		return $TicketArupado;
	}			
}
