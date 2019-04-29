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
class TblPermisos extends Eloquent
{
    protected $table = 'tbl_permisos';
    public $timestamps = false;

    protected $casts = [
        'tipo' => 'int',
        'estado' => 'int',
    
    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [
        
    ];

    public static function PermisoListarJson()
    {
        $listar = DB::table('tbl_permisos as tbl')
            ->select(
                'tbl.id',
                'tbl.tipo',
                'tbl.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.fecha_registro',
                'tbl.estado'
                )
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoNombre($nombre)
    {
        $listar = DB::table('tbl_permisos as tbl')
            ->select(
                'tbl.id',
                'tbl.tipo',
                'tbl.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.fecha_registro',
                'tbl.estado'
                )
            ->where('nombre',$nombre)
            ->first();
        return $listar;
    }
    public static function PermisosInsertarJson(Request $request)
    {       
        $idPermisoUsuarioInsertado = DB::table('tbl_permisos')->insertGetId([            
            'fecha_registro' => date('Y-m-d H:i:s'),
            'tipo' => $request->txtTipo,
            'nombre' => $request->txtNombre,
            'controller' => $request->txtController,
            'method' => $request->txtMethod,
            'descripcion' => $request->txtDescripcion,
            'estado' => 1,
        ]);                 
        return $idPermisoUsuarioInsertado;
    }  

    public static function PermisosActualizarJson($permisosID)
    {       
        DB::table('tbl_permisos')->where('id', '=',$permisosID)->first()->delete();
        $respuesta=true;    
        return $respuesta;
    } 

    public static function PermisosLimpiar()
    {       
        DB::table('tbl_permisos')->where('id', '>',0)->delete();
        $respuesta=true;    
        return $respuesta;
    }

     public static function PermisoListar()
    {
        $listar = DB::table('tbl_permisos as tbl')
            ->select(
                'tbl.id',
                'tbl.tipo',
                'tbl.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.fecha_registro',
                'tbl.estado'
                )
            ->get();
        return $listar;
    }

    public static function PermisosEliminar($id)
    {       
        DB::table('tbl_permisos')->where('id',$id)->delete();
        $respuesta=true;    
        return $respuesta;
    }
}
