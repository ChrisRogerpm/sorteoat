<?php

namespace App\Http\Controllers;

use App\Models\TblLocalVenta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function ListarLocal()
    {
        return view('Local.ListarLocalVista');
    }

    public function ListarLocalJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblLocalVenta::ListarLocalesVenta();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function SincronizarLocalVentaJson()
    {
        $respuesta = false;
        $mensaje = "";
        try {
            TblLocalVenta::SincronizarLocalVenta();
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }

    public function SincronizarLocalVentaId(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try {
            TblLocalVenta::SincronizarLocalVentaId($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }
}
