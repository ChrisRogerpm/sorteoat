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

class TblUsuarioPj extends Eloquent
{
	public $timestamps = false;
			
	public static function ListarUsuarioPjJson(){		
		$lista=DB::table('tbl_usuarios_pj')->get();
        return $lista;
	}		
}
