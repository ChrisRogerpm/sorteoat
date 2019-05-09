<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\TblSorteo, App\Models\TblRestriccione, App\Models\TblBeneficio, App\Models\TblCliente, App\Models\TblGanador;
use Illuminate\Support\Facades\Route;
use App\Models\TblGeneracionOpcionesSorteo;
use App\Http\Controllers\SeguridadController;
use App\Models\TblConsolidadoOpcionesSorteo;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class SorteoController extends Controller
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
                    return response()->json(['error' => 'Unauthenticated.'], 401)->send();
                } else {
                    return abort('401')->send();

                }
            } else {
                return $next($request);
            }
        });
    }

    public function SorteoActivoValidarJson($id)
    {
        $respuesta = false;
        try {
            TblSorteo::SorteoActivar();
            $respuesta = TblSorteo::SorteoActivoValidarJson();
            $cliente = TblCliente::ObtenerClienteJson(Crypt::decryptString($id));
            TblCliente::VerificarCorreClienteJson($cliente->ID);
            $opciones = TblConsolidadoOpcionesSorteo::ObtenerTotalConsolidadoOpcionesSorteosJson($cliente->ID);
            if (!$opciones) {
                $opciones = new \stdClass();
                $opciones->total = 0;
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        if ($respuesta == 1 && $cliente->verificacionCorreo == 1) {
            return view('AllinOne', ["cliente" => $cliente, "opciones" => $opciones]);
        } else {
            return view('AllinOneDisabled');
        }
    }

    public function SorteoListarVista()
    {
        return view('Sorteos.listadoSorteo');
    }

    public function InsertarSorteoVista()
    {
        return view('Sorteos.nuevoSorteo');
    }

    public function AnimacionSorteo()
    {
        return view('AnimacionSorteo');
    }

    public function SorteoInsertarJson(Request $request)
    {

        $respuesta = false;
        $mensaje_error = "";
        try {
            TblSorteo::DesactivarSorteoJson();
            $esVigente = TblSorteo::SorteoVigenteObtenerJson($request);
            if ($esVigente == 1) {
                $respuesta = false;
                $mensaje_error = 'Ya existe un Sorteo Vigente.';
            } else {
                $idSorteoInsertado = TblSorteo::SorteoInsertarJson($request);
                if (empty($idSorteoInsertado)) {
                    $respuesta = false;
                } else {
                    $idRestriccionInsertado = TblRestriccione::RestriccionInsertarJson($request, $idSorteoInsertado);
                    $i = 1;
                    foreach ($request->arrBeneficios as $beneficio) {
                        if ($request->txtPorRegiones == 1) {
                            $tmp = TblBeneficio::BeneficioInsertarJson($beneficio, $idSorteoInsertado, $i);
                        } else {
                            $tmp = TblBeneficio::BeneficioInsertarJson($beneficio, $idSorteoInsertado, 0);
                        }
                        $i++;
                    }
                }
                TblSorteo::SorteoActivar();
                $respuesta = true;
                $mensaje_error = 'Se inserto Sorteo Correctamente.';
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
        //return response()->json(['asd'=>date('Y-m-d H:i:s'),'asd2'=>'asd']);     
    }

    public function SorteoListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblSorteo::SorteoListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ConsultarIniciadoSorteoJson()
    {
        $response = "";
        $mensaje = "";
        $gnd = "";
        $clienteGanador = "";
        $asd = "";
        $clientes = "";
        try {
            //$response = TblSorteo::ConsultarIniciadoSorteoJson();
            $sorteoTmp = TblSorteo::ConsultarIniciadoSorteoJson();
            //dd($sorteoTmp);
            if (!$sorteoTmp) {
                $response = false;
            } else {
                $response = true;
                $clientes = TblCliente::ListarClienteJson();
                if (count($clientes) == 55) {
                    $sorteo = TblSorteo::ObtenerIniciadoSorteoJson();
                    $beneficio = TblBeneficio::ObtenerNumeroGanadorBeneficioJson($sorteo->iniciado);
                    $clienteGanador = TblGanador::ObtenerGanadorJson($beneficio->id, $beneficio->numero_ganador);
                    $cliente = TblCliente::ObtenerClienteJson($clienteGanador->id_cliente);
                    $gnd = $cliente->nombre . ' ' . $cliente->apellidoPaterno . ' ' . $cliente->apellidoMaterno;
                    TblSorteo::PararSorteoJson($sorteo->id);
                } else {
                    $response = false;
                }
            }
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $response, 'qwerty' => $gnd, 'mensaje' => $mensaje, 'clientes' => $clientes]);
    }

    public function IniciarSorteoJson(Request $request)
    {
        $response = "";
        $mensaje = "";
        $gnd = "";
        $clienteGanador = "";
        try {
            $sorteo = TblSorteo::ObtenerIniciadoSorteoJson();
            if (!$sorteo) {
                $tmpSorteo = TblSorteo::ObtenerSorteoJson($request->idSorteo);
                $fechaActual = Carbon::now()->format('Y-m-d G:i:s');
                $fechaFin = Carbon::parse($tmpSorteo->fecha_fin);
                $fechaActual = Carbon::parse($fechaActual);
                if ($fechaActual->greaterThanOrEqualTo($fechaFin)) {
                    $beneficio = TblBeneficio::ObtenerBeneficioJson($request->idBeneficio);
                    $clientes = TblConsolidadoOpcionesSorteo::ValidarClientesConsolidadoOpcionesSorteoJson($request->idSorteo, $beneficio->region);
                    if ($beneficio->region == 0) {
                        if (count($clientes) >= 1) {
                            $response = TblSorteo::IniciarSorteoJson($request->idSorteo, $request->idBeneficio);
                            $sorteo = TblSorteo::ObtenerIniciadoSorteoJson();

                            for ($i = 0; $i < 3; $i++) {
                                $ranking = $i + 1;
                                $gnd = TblConsolidadoOpcionesSorteo::ObtenerGanadorProbabilidadGeneracionOpcionesSorteo($request->idSorteo, $beneficio->region);
                                TblBeneficio::ActualizarBeneficioJson($gnd->numeroGanador, $request->idBeneficio);
                                TblGanador::InsertarGanadorJson($sorteo, $gnd->numeroGanador, $gnd->id_cliente, $ranking);
                            }

                            $mensaje = "Se Inicio el Sorteo Correctamente";
                        } else {
                            $response = false;
                            $mensaje = "No hay Suficientes Clientes para Crear Animacion del Sorteo.";
                        }
                    } else {
                        if (count($clientes) == 55) {
                            $response = TblSorteo::IniciarSorteoJson($request->idSorteo, $request->idBeneficio);
                            $sorteo = TblSorteo::ObtenerIniciadoSorteoJson();
                            for ($i = 0; $i < 3; $i++) {
                                $ranking = $i + 1;
                                $gnd = TblConsolidadoOpcionesSorteo::ObtenerGanadorProbabilidadGeneracionOpcionesSorteo($request->idSorteo, $beneficio->region);
                                TblBeneficio::ActualizarBeneficioJson($gnd->numeroGanador, $request->idBeneficio);
                                TblGanador::InsertarGanadorJson($sorteo, $gnd->numeroGanador, $gnd->id_cliente, $ranking);
                            }
                            $mensaje = "Se Inicio el Sorteo Correctamente";
                        } else {
                            $response = false;
                            $mensaje = "No hay Suficientes Clientes para Crear Animacion del Sorteo.";
                        }
                    }
                } else {
                    $response = false;
                    $mensaje = "La Fecha Final del Sorteo Aún se Encuentra Vigente.";
                }
            } else {
                $response = false;
                $mensaje = "Ya se Ha iniciado un Sorteo.";
            }
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $response, 'mensaje' => $mensaje, 'gnd' => $gnd]);
    }
}
