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
class TblPermisosPerfil extends Eloquent
{
    protected $table = 'tbl_permisos_perfil';
    public $timestamps = false;

    protected $casts = [
        'usuario_id' => 'int',
        'permiso_id' => 'int',
    
    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [
        
    ];

    public static function PermisoPerfilListarJson(Request $request)
    {
        $listar = DB::table('tbl_permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
                )
            ->where('tbl.perfil_id', $request->txtPerfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoIDPerfilIDListarJson(Request $request)
    {
        $listar = DB::table('tbl_permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
                )
            ->where('tbl.permiso_id', $request->txtPermisoID)
            ->where('tbl.perfil_id', $request->txtPerfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }
    public static function PermisoPerfilInsertarJson(Request $request)
    {       
        $idPermisoPerfilInsertado = DB::table('tbl_permisos_perfil')->insertGetId([            
            'fecha_registro' => date('Y-m-d H:i:s'),
            'perfil_id' => $request->txtPerfilID,
            'permiso_id' => $request->txtPermisoID,
            'estado' => 1
        ]);                 
        return $idPermisoPerfilInsertado;
    }  

    public static function PermisoPerfilActualizarJson(Request $request)
    {       
        DB::table('tbl_permisos_perfil')->where('permiso_id', '=',$request->txtPermisoID)->where('perfil_id', '=',$request->txtPerfilID)->delete();
        $respuesta=true;    
        return $respuesta;
    } 

    public static function PermisoIDPerfilIDBuscarJson($permisoID,$perfilID)
    {
        $listar = DB::table('tbl_permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
                )
            ->where('tbl.permiso_id', $permisoID)
            ->where('tbl.perfil_id', $perfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoPerfilIDEliminar($id)
    {       
        DB::table('tbl_permisos_perfil')->where('permiso_id',$id)->delete();
        $respuesta=true;    
        return $respuesta;
    }
}
