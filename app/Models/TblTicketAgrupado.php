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

class TblTicketAgrupado extends Eloquent
{
	public $timestamps = false;
		
	public static function InsertarTicketAgrupadoJson(){
		$id=DB::table('tbl_ticket_agrupado')->insertGetId([            
			'codigo' => 'pendiente',
			'estado' => 1,
			'fecha_registro' => date('Y-m-d H:i:s')		
		]); 
		return $id;
	}		
	public static function ActualizarTicketAgrupadoJson($id,$codigo){		
		DB::table('tbl_ticket_agrupado')->where('id', $id)->update(
            [
                'codigo' => $codigo
            ]
        );
        return true;
	}
	public static function ObtenerTicketAgrupadoJson($codigo){		
		$ticketAgrupado=DB::table('tbl_ticket_agrupado')->where([['codigo','=',$codigo]])->first();
        return $ticketAgrupado;
	}
	public static function InhabilitarTicketAgrupadoJson($id){		
		DB::table('tbl_ticket_agrupado')->where('id', $id)->update(
            [
                'estado' => 0
            ]
        );
        return true;
	}	
}
