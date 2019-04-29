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
 * Class TblConsolidadoOpcionesSorteo
 *
 * @property int $id
 * @property int $id_cliente
 * @property int $id_sorteo
 * @property string $unit_id
 * @property string $local
 * @property string $game
 * @property int $cantidad_opciones
 * @property \Carbon\Carbon $fecha_registro
 * @property int $id_tienda
 * @property int $cantidad_tickets
 *
 * @package App\Models
 */
class TblAuditoria extends Eloquent
{
    protected $table = 'tbl_auditoria';
    public $timestamps = false;

    protected $casts = [
        'usuario_id' => 'int',
       
    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [
        
    ];

    public static function ReporteAuditoriaListarJson(Request $request)
    {
        $listar = DB::table('tbl_auditoria as tbl')
            ->select(
                'tbl.id',
                'tbl.fecha_registro',
                'tbl.usuario_id',
                'tbl.permiso',
                'usu.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.data'
                )
              ->join('tbl_usuarios as usu', 'usu.id','tbl.usuario_id')
              ->when($request->txtUsuario!='t', function($query,$idusuario){
                return $query->where('tbl.usuario_id', $idusuario);
            })
            ->whereBetween('tbl.fecha_registro', array(date('Y-m-d H:i:s',strtotime($request->txtFechaInicio)), date('Y-m-d H:i:s',strtotime($request->txtFechaFin))))
            ->orderBy('id', 'desc')
            ->get();
        return $listar;
    }

    public static function DataAuditoriaJson(Request $request)
    {
        $listar = DB::table('tbl_auditoria as tbl')
            ->select(
                'tbl.id',
                'tbl.fecha_registro',
                'tbl.usuario_id',
                'tbl.permiso',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.data'
                )
            ->where('tbl.id', '=',$request->txtAuditoriaID)
            ->first();
        return $listar;
    }
}
