<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TblCliente;

class SoporteController extends Controller
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
    public function EditarClienteVista()
    {                        
        return view('Cliente.EditarClienteVista');  
    }      
    public function BuscarClientesJson(Request $request)
    {        
        $data=false;
        $mensaje_error = "";
        try {            
            $data=TblCliente::ObtenerDniCorreoClienteJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $data, 'mensaje' => $mensaje_error ]);        
    }    
    public function ActualizarDNIClienteJson(Request $request)
    {        
        $response=false;
        $mensaje_error = "";
        try {            
            $response=TblCliente::ActualizarDNIClienteJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $response, 'mensaje' => $mensaje_error ]);        
    }
}
