<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblPermisos;
use App\Models\TblPermisosPerfil;
use App\Models\TblUsuarios;
use App\Models\TblAuditoria;
use Illuminate\Support\Facades\Route;

class SeguridadController extends Controller
{

   public function __construct()
   {
       $this->middleware(function ($request, $next) {
           $app = app();
           $controller = app('App\Http\Controllers\SeguridadController')->BuscarPermiso($request);
           $respuesta = $controller;
           if (!$respuesta) {
               //echo $respuesta;
               if ($request->ajax()) {
                   return response()->json(['error' => 'Unauthenticated.', 'permiso' => Route::current()->uri()], 401)->send();
               } else {
                   return abort('401')->send();

               }
           } else {
               return $next($request);
           }
       });
   }

    public function PermisosUsuarioVista()
    {
        return view('Seguridad.permisoUsuario');
    }

    public function PermisoPerfilListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista_Permisos = TblPermisos::PermisoListarJson();
            $lista_Perfil = TblPermisosPerfil::PermisoPerfilListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => [$lista_Permisos, $lista_Perfil], 'mensaje' => $mensaje_error]);
    }

    public function PermisoListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblPermisos::PermisoListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function PermisoPerfilJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        $respuesta = false;
        try {
            $Permiso_perfil = TblPermisosPerfil::PermisoIDPerfilIDListarJson($request);
            //echo count($Permiso_perfil);exit();
            if (count($Permiso_perfil) > 0) {
                $eliminar = TblPermisosPerfil::PermisoPerfilActualizarJson($request);
                $respuesta = true;
            } else {
                $insertar = TblPermisosPerfil::PermisoPerfilInsertarJson($request);
                $respuesta = true;

            }
            $mensaje_error = 'Se Modifico Correctamente.';
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function ActualizarPerfilUsuario(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        $respuesta = false;
        try {
            $lista = TblUsuarios::ActualizarPerfilJson($request);
            $mensaje_error = "Se Actualizo Correctamente.";
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function DataAuditoriaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblAuditoria::DataAuditoriaJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    ///////permisos
    public function BarridoPermisos()
    {
        $respuesta = true;
        $mensaje_error = "Transaccion Realizada Correctamente.";
        try {
            //$eliminar = TblPermisos::PermisosLimpiar();
            $routeCollection = Route::getRoutes();

            $permisos_route_array = [];
            foreach ($routeCollection as $value) {
                array_push($permisos_route_array, $value->uri());
            }

            $permisos_route_array_BD = [];
            $listapermisos = TblPermisos::PermisoListar();
            foreach ($listapermisos as $value) {
                $nombrePermiso_DB = $value->nombre;
                $position = in_array($nombrePermiso_DB, $permisos_route_array);
                if (!$position) {
                    $eliminar_permiso_perfil = TblPermisosPerfil::PermisoPerfilIDEliminar($value->id);
                    $eliminar_permiso = TblPermisos::PermisosEliminar($value->id);
                } else {
                    array_push($permisos_route_array_BD, $nombrePermiso_DB);
                }
            }

            foreach ($routeCollection as $value) {
                $position = in_array($value->uri(), $permisos_route_array_BD);
                if (!$position) {
                    //echo $position;
                    $uri_entrante = $value->uri();
                    $validar = strpos($uri_entrante, 'Fk');
//                    if($value->uri()!="BarridoPermisos" ||$value->uri()!="ValidarLoginJson" || $value->uri()!="Login" || $value->uri()!="ListdoUsuariosSelect" || $value->uri()!="DataAuditoriaRegistro"){
                    if (!$validar){
                        DB::table('tbl_permisos')->insertGetId(
                            [
                                'fecha_registro' => date('Y-m-d H:i:s'),
                                'nombre' => $value->uri(),
                                'controller' => $value->getActionName(),
                                'method' => $value->methods()[0],
                                'estado' => 1,
                            ]
                        );
                }
            }

        }
            //echo var_dump($permisos_route_array_BD);
          // exit();
        } catch (QueryException $ex)
{
$mensaje_error = $ex->errorInfo;
}

return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
}

public
function BuscarPermiso(Request $request)
{
    $respuesta = true;
    $mensaje_error = "No Tiene Permiso";

    try {
        //session()->flush();
        $usuarioID = session()->get('usuarioID');
        $perfilID = session()->get('perfilID');
        //dd($usuarioID);
        $currentRoute = Route::current()->uri();
        $permisoNombre = TblPermisos::PermisoNombre($currentRoute);
        //echo var_dump($permisoNombre->id);exit();
        $permisoID = 0;
        if (!is_null($permisoNombre)) {
            $permisoID = $permisoNombre->id;
        }
        //echo print_r($request->all(), true);exit();
        if ($permisoID > 0) {
            $insertar_Auditoria = DB::table('tbl_auditoria')->insertGetId(
                [
                    'fecha_registro' => date('Y-m-d H:i:s'),
                    'usuario_id' => $usuarioID,
                    'permiso' => Route::current()->uri(),
                    'controller' => Route::current()->getActionName(),
                    'method' => Route::current()->methods()[0],
                    'data' => json_encode($request->all()),
                ]
            );

            $lista = TblPermisosPerfil::PermisoIDPerfilIDBuscarJson($permisoID, $perfilID);
            if (count($lista) > 0) {
                $respuesta = true;
            } else {
                //echo $respuesta;exit();
                $respuesta = false;
            }
        } else {
            $respuesta = false;
        }

    } catch (QueryException $ex) {
        $mensaje_error = $ex->errorInfo;
    }
    return $respuesta;
}

// REGION MANTENIMIENTO USUARIO

public
function UsuarioListarVista()
{
    return view('Usuario.UsuarioListarVista');
}

public
function UsuarioInsertarVista()
{
    return view('Usuario.UsuarioInsertarVista');
}

public
function UsuarioEditarVista($idUsuario)
{
    $Usuario = TblUsuarios::findorfail($idUsuario);
    return view('Usuario.UsuarioEditarVista', compact('Usuario'));
}


public
function UsuarioListarJson()
{
    $lista = "";
    $mensaje_error = "";
    try {
        $lista = TblUsuarios::UsuarioListarJson();
    } catch (QueryException $ex) {
        $mensaje_error = $ex->errorInfo;
    }

    return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
}

public
function UsuarioInsertarJson(Request $request)
{
    $respuesta = false;
    $mensaje_error = "";
    try {
        TblUsuarios::UsuarioInsertarJson($request);
        $respuesta = true;
    } catch (QueryException $ex) {
        $mensaje_error = $ex->errorInfo;
    }
    return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
}

public
function UsuarioEditarJson(Request $request)
{
    $respuesta = false;
    $mensaje_error = "";
    try {
        TblUsuarios::UsuarioEditarJson($request);
        $respuesta = true;
    } catch (QueryException $ex) {
        $mensaje_error = $ex->errorInfo;
    }
    return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
}

// FIN REGION MANTENIMIENTO USUARIO
}
