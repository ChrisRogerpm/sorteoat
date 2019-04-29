<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class TblUbigeo extends Eloquent
{
	protected $table = 'tbl_ubigeo';
	public $incrementing = false;
	public $timestamps = false;
		
	public static function ObtenerUbigeoJson($departamento)
	{		
		$ubigeo=DB::table('tbl_ubigeo')->where([
            ['cod_depa', '=', $departamento],
            ['cod_prov', '=', 0],
            ['cod_dist', '=', 0]
        ])->first();
        return $ubigeo;
	}
}
