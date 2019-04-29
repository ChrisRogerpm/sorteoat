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
 * Class TblRestriccione
 * 
 * @property int $id
 * @property int $id_sorteo
 * @property string $descripcion
 * @property float $valor_apuesta
 *
 * @package App\Models
 */
class TblRestriccione extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'id_sorteo' => 'int',
		'valor_apuesta' => 'float',
		'caducidad_ticket' => 'int',
		'porRegiones' => 'int'	
	];

	protected $fillable = [
		'id_sorteo',
		'descripcion',
		'valor_apuesta',
		'caducidad_ticket',
		'porRegiones'
	];
	public static function RestriccionInsertarJson(Request $request,$idSorteoInsertado)
	{
		$idRestriccionInsertado = DB::table('tbl_restricciones')->insertGetId([            
			'id_sorteo' => $idSorteoInsertado,
			'descripcion' => $request->txtDescripcionRestriccion,
			'valor_apuesta' => $request->txtValorApuesta,
			'caducidad_ticket' => $request->txtTiempoCaducidadTicket,
			'porRegiones' => $request->txtPorRegiones,
		]); 
		return $idRestriccionInsertado;
	}
	public static function ObtenerRestriccionJson($idSorteo)
	{
		$restriccion = TblRestriccione::where('id_sorteo', '=',$idSorteo)->first();				       
		return $restriccion;
	}
}
