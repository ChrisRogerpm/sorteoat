<?php

namespace App\Http\Controllers;

use App\Models\TblUbigeo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\TblCliente;
use App\Http\Controllers\SeguridadController;
use App\Models\TblAuditoria, App\Models\Curl, App\Models\TblGeneracionOpcionesSorteo, App\Models\TblConsolidadoOpcionesSorteo, App\Models\TblGanador;


class ReporteController extends Controller
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

    public function ReporteClientes()
    {
        return view('Reportes.ReporteClientes');
    }

    public function ReporteGanadores()
    {
        return view('Reportes.ReporteGanadores');
    }

    public function ReporteLocales()
    {
        return view('Reportes.ReporteLocales');
    }

    public function ReporteClientesConsulta()
    {
        return view('Reportes.ReporteClientesConsulta');
    }

    public function ReporteClientesJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblConsolidadoOpcionesSorteo::ReporteClienteListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ReporteGanadoresJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblGanador::ListarGanadorJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ReporteLocalesJson(Request $request)
    {
        $lista = "";
        $lista1 = "";
        $mensaje_error = "";
        try {
            $lista = TblConsolidadoOpcionesSorteo::ReporteApuestaLocalesJson($request);
            $lista1 = TblConsolidadoOpcionesSorteo::ReporteApuestaGameJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => [$lista, $lista1], 'mensaje' => $mensaje_error]);
    }

    //REPORTE SORTEOS
    public function ReporteOpcionesSorteos()
    {
        return view('Reportes.ReporteOpcionesSorteos');
    }

    public function ReporteOpcionesSorteosJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblGeneracionOpcionesSorteo::ReporteOpcionesSorteosListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
        //return response()->json(['data' => $request->arrJuegos[0]]);        
    }

    ///// inicio reporte auditoriaaa  

    public function ReporteAuditoriaVista()
    {
        return view('Seguridad.reporteAuditoria');
    }

    public function ReporteAuditoriaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblAuditoria::ReporteAuditoriaListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    ////fin reporte auditoria
    public function ListadoLocalesJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
            $curl = New Curl($s3k_password);
            $lista = $curl->ListarLocalJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ListadoClientesJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            //$lista = Curl::consultarLocal(290737411);     

            //$lista=$curl->ListarLocalJson();      
            $lista = TblCliente::ListadoClientesJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ListadoClientesConsultaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {

            $lista = TblCliente::ListadoClientesConsultaJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}
