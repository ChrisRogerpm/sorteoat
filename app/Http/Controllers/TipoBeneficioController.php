<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoBeneficioController extends Controller
{
    public function Listado(){
        $arr_tipo_beneficio = DB::table('tbl_tipo_beneficio')->select('id', 'descripcion')->get();
        return response()->json(['data'=>$arr_tipo_beneficio]);   
    }
}
