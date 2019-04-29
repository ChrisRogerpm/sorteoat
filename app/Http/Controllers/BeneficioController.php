<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TblBeneficio;


class BeneficioController extends Controller
{
    public function ListadoBeneficioJson(Request $request){
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TblBeneficio::ListadoBeneficioJson($request->idSorteo);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);        
    }
}
