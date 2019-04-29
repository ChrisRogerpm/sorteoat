<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;
use Carbon\Carbon;

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
class TblUsuarios extends Eloquent
{
    protected $table = 'tbl_usuarios';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'estado' => 'int',
    
    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [
        'perfil_id', 'nombre', 'contrasena','tienda_nombre','tienda_id', 'fecha_registro', 'estado'
    ];

    public static function ObtenerActivoUsuarioJson($usuarioId)
    {
        $usuario = DB::table('tbl_usuarios as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.nombre',
                'tbl.tienda_nombre',
                'tbl.fecha_registro',
                'tbl.estado'
                )
            ->where('id',$usuarioId)
            ->first();
        return $usuario;
    }

    public static function ValidarUsuarioJson(Request $request)
    {
        $usuario = DB::table('tbl_usuarios as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.nombre',
                'tbl.tienda_nombre',
                'tbl.fecha_registro',
                'tbl.estado',
                'contrasena'
                )
            ->where([['nombre','=',strtolower($request->user) ],['contrasena','=',md5($request->password)]])
            ->first();
        return $usuario;        
    }
    public static function UsuarioListarJson()
    {
        $listar = DB::table('tbl_usuarios as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.nombre',
                'tbl.tienda_nombre',
                'tbl.fecha_registro',
                'tbl.estado'
                )
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function UsuarioInsertarJson(Request $request)
    {       
        $idPermisoUsuarioInsertado = DB::table('tbl_usuarios')->insertGetId([            
            'fecha_registro' => date('Y-m-d H:i:s'),
            'perfil_id'=> $request->input('txtPerfil'),
            'nombre' => $request->input('txtNombre'),
            'contrasena'=> md5($request->input('txtPassword')),
            //'contrasena'=> bcrypt($request->input('txtPassword')),
            'estado' => 1,
        ]);                 
        //$Usuario->password = bcrypt($request->input('Usuario'));
        return $idPermisoUsuarioInsertado;
    }  

    public static function UsuarioActualizarJson($usuarioID)
    {       
        //TblUsuarios::where('id', '=',$usuarioID)->first()->update(['estado_sorteo'=>1]);
        DB::table('tbl_usuarios')->where('id', '=',$usuarioID)->first()->delete();
        $respuesta=true;    
        return $respuesta;
    } 

    public static function UsuarioEditarJson(Request $request)
    {
        $id = $request->input('id');

        $contrasena = $request->input('txtPassword');
        $contrasena = $contrasena == null ? '' : $contrasena;
        //$contrasena = $contrasena == null ? '' : bcrypt($contrasena);
        $TblUsuarios = TblUsuarios::findorfail($id);
        
        $TblUsuarios->nombre = $request->input('txtNombre');
        $TblUsuarios->perfil_id = $request->input('cboPerfil');
        $TblUsuarios->estado = $request->input('cboEstado');
        
        //$TblUsuarios->fecha_registro = Carbon::now(); // si es fecha de modificaicon
        $TblUsuarios->save();
        return $TblUsuarios;

        // $update = DB::select(DB::raw("select puntodeventa.idPuntoVenta,puntodeventa.nombre as tienda,caj.nombre as caja, ape.fechaOperacion as fechaOperacion, tur.nombre as turno from apertura_caja  ape
        // left join turno tur on tur.idTurno=ape.idTurno
        // left join caja caj on caj.idCaja=ape.idCaja
        // left join punto_venta as puntodeventa on puntodeventa.idPuntoVenta=caj.idCaja
        // where ape.usuario =".$usuario." and ape.estado=1"));
        // return $update;
    }

    public static function ActualizarPerfilJson(Request $request)
    {       
         DB::table('tbl_usuarios')->where('id', '=',$request->txtUsuarioID)->update(['perfil_id'=>$request->txtPerfilID]);
        $respuesta=true;    
        return $respuesta;
    }
}
