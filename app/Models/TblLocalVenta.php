<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TblLocalVenta extends Model
{
    protected $table = 'tbl_local_venta';

    protected $primaryKey = 'id';

    protected $fillable = [
        'idUbigeo',
        'nombre',
        'cc_id',
        'unit_ids'
    ];

    public $timestamps = false;

    public static function SincronizarLocalVenta()
    {
        $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
        $curl = New Curl($s3k_password);
        $lista = $curl->ListarLocalJson();

        foreach ($lista as $data) {
            $data_unit_ids = $data['unit_ids'];
            $unit_ids = "";
//            $ultimo_unit_id = "";
            for ($i = 0; $i < count($data_unit_ids); $i++) {
                $data_ultimo_indice = count($data_unit_ids) - 1;
                if ($data_ultimo_indice == $i) {
                    $unit_ids .= $data_unit_ids[$i];
//                    $ultimo_unit_id = $data_unit_ids[$i];
                } else {
                    $unit_ids .= $data_unit_ids[$i] . ",";
//                    $ultimo_unit_id = $data_unit_ids[$i];
                }
            }
//            $response = $curl->consultarLocal($ultimo_unit_id);
//            $result = $response['result'];
//            $departamento = $result["ubigeo_id"];
//            if (strlen($departamento) > 2) {
//                $departamento = substr($departamento, 0, 2);
//            } else {
//                $departamento = $departamento;
//            }
//            $idUbigeo = TblUbigeo::ObtenerUbigeoJson((int)$departamento);

            if ($data['cc_id'] != "") {
                $validar = TblLocalVenta::where('cc_id', $data['cc_id'])->first();
                if ($validar == null) {
                    $local_venta = new TblLocalVenta();
                    $local_venta->nombre = $data['nombre'];
                    $local_venta->cc_id = $data['cc_id'];
//                    $local_venta->idUbigeo = $idUbigeo->id;
                    $local_venta->unit_ids = $unit_ids;
                    $local_venta->save();
                }
//                else {
//                    $local_venta = TblLocalVenta::findorfail($validar->id);
//                    $local_venta->nombre = $data['nombre'];
//                    $local_venta->cc_id = $data['cc_id'];
//                    $local_venta->idUbigeo = $idUbigeo->id;
//                    $local_venta->unit_ids = $unit_ids;
//                    $local_venta->save();
//                }
            }
        }
    }

    public static function SincronizarLocalVentaId(Request $request)
    {
        $cc_id = $request->input('cc_id');

        $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
        $curl = New Curl($s3k_password);
        $lista = $curl->ListarLocalJson();

        foreach ($lista as $data) {

            if ($data['cc_id'] == $cc_id){

                $local_venta = TblLocalVenta::where('cc_id', $cc_id)->first();
//                $u_ids = explode(',', $local_venta->unit_ids);
//                $ultimo_unit_id = end($u_ids);

                $data_unit_ids = $data['unit_ids'];
                $unit_ids = "";
                $ultimo_unit_id = "";
                for ($i = 0; $i < count($data_unit_ids); $i++) {
                    $data_ultimo_indice = count($data_unit_ids) - 1;
                    if ($data_ultimo_indice == $i) {
                        $unit_ids .= $data_unit_ids[$i];
                        $ultimo_unit_id = $data_unit_ids[$i];
                    } else {
                        $unit_ids .= $data_unit_ids[$i] . ",";
                        $ultimo_unit_id = $data_unit_ids[$i];
                    }
                }

                $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
                $curl = New Curl($s3k_password);
                $response = $curl->consultarLocal($ultimo_unit_id);
                $result = $response['result'];
                $departamento = $result["ubigeo_id"];
                if (strlen($departamento) > 2) {
                    $departamento = substr($departamento, 0, 2);
                } else {
                    $departamento = $departamento;
                }
                $idUbigeo = TblUbigeo::ObtenerUbigeoJson((int)$departamento);

                $local_venta = TblLocalVenta::findorfail($local_venta->id);
                $local_venta->nombre = $data['nombre'];
                $local_venta->cc_id = $data['cc_id'];
                $local_venta->idUbigeo = $idUbigeo->id;
                $local_venta->unit_ids = $unit_ids;
                $local_venta->save();

            }

        }
    }

    public static function ValidarLocalVenta($cc_id)
    {
        $resultado = false;
        $cantidad = DB::table('tbl_local_venta')
            ->where('cc_id', $cc_id)
            ->count();
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

    public static function ListarLocalesVenta()
    {
        $data = DB::select(DB::raw("SELECT v.id,u.nombre Ubigeo,v.nombre LocalVenta, v.cc_id,v.unit_ids
        FROM tbl_local_venta v
        LEFT JOIN tbl_ubigeo u ON u.id = v.idUbigeo"));
        return $data;
    }
}
