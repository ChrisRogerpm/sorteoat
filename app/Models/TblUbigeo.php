<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use DB;

class TblUbigeo extends Eloquent
{
    protected $table = 'tbl_ubigeo';
    public $incrementing = false;
    public $timestamps = false;

    public static function ObtenerUbigeoJson($departamento)
    {
        $ubigeo = DB::table('tbl_ubigeo')->where([
            ['cod_depa', '=', $departamento],
            ['cod_prov', '=', 0],
            ['cod_dist', '=', 0]
        ])->first();
        return $ubigeo;
    }

    public static function ObtenerDepartamentoUbigeoJson($unit_id)
    {
//        $data = DB::select(DB::raw("SELECT * FROM tbl_local_venta l
//        WHERE l.unit_ids LIKE '%$unit_id%'"))[0];
        $data = DB::table('tbl_local_venta as l')
            ->where('l.unit_ids', 'like', '%' . $unit_id . '%')
            ->first();
        if ($data != null){
            $ubigeo = TblUbigeo::findorfail($data->idUbigeo);
            return $ubigeo->nombre;
        }else{
            return 'No Registrado';
        }

    }
}
