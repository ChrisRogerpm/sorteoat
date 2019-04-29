<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TblTerminosCondiciones;


class TerminoCondicionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next)
        {
            $app = app();
            $controller = app('App\Http\Controllers\SeguridadController')->BuscarPermiso($request);
            $respuesta = $controller;
            if(!$respuesta){
                //echo $respuesta;
                if ($request->ajax()){
                    return response()->json(['error' => 'Unauthenticated.','permiso'=>Route::current()->uri()], 401)->send();
                }
                else{
                    return abort('401')->send();
                    
                }
            }
            else{
               return $next($request); 
            }
       });               
    }  
    public function EditarTerminosCondicionesVista()
    {
        return view('TerminoCondicion.InsertarTerminoCondicion');
    }
    public function InsertarTerminoCondicionJson(Request $request)
    {
        $response = false;
        $lista = "";
        $mensaje = "";
        try {
            $lista=TblTerminosCondiciones::ListarTerminoCondicionJson();
            if( count($lista) ==0 ){
                $response = TblTerminosCondiciones::InsertarTerminoCondicionJson($request->txtDescripcion);
                $mensaje = "Se Inserto Correctamente los Terminos y Condiciones.";
            }
            else{
                $response = TblTerminosCondiciones::EditarTerminoCondicionJson($lista[0]->id,$request->txtDescripcion);
                $mensaje = "Se Edito Correctamente los Terminos y Condiciones.";
            }
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['data' => $response, 'mensaje' => $mensaje]);        
    }
    public function ObtenerTerminoCondicionJson()
    {       
        $lista = "";
        $mensaje = "";
        try {
            $lista=TblTerminosCondiciones::ObtenerTerminoCondicionJson();            
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje]);        
    }    
}
