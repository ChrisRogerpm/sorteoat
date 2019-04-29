<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class TblTerminosCondiciones extends Eloquent
{
	protected $table = 'tbl_terminos_condiciones';
	public $incrementing = false;
	public $timestamps = false;
	
	public static function InsertarTerminoCondicionJson($descripcion)
	{
		DB::table('tbl_terminos_condiciones')->insertGetId(['descripcion' => $descripcion]); 
		return true;
	}
	public static function EditarTerminoCondicionJson($id,$descripcion)
	{		
		DB::table('tbl_terminos_condiciones')->where('id','=',$id)->update(['descripcion'=>$descripcion]);	
		return true;
	}
	public static function ListarTerminoCondicionJson()
	{		
		$lista=DB::table('tbl_terminos_condiciones')->get();	
		return $lista;
	}
	public static function ObtenerTerminoCondicionJson()
	{		
		$lista=DB::table('tbl_terminos_condiciones')->get()->first();	
		return $lista;
	}	
}
