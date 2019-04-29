<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TblTicketAgrupado,App\Models\TblDetalleTicketAgrupado;
use \Milon\Barcode\DNS1D;


class CajaController extends Controller
{
    public function RegistroTicketsVista()
    {                        
        return view('Caja.Caja');  
    }  
    public function GenerarTicketAgrupadoJson(Request $request)
    {        
        $mensaje_error = "";
        $arrayInsertados=[];
        try {
            $id = TblTicketAgrupado::InsertarTicketAgrupadoJson();
            foreach ($request->data as $valor) {
                $estado=TblDetalleTicketAgrupado::InsertarDetalleTicketAgrupadoJson($id,$valor['NroTicket']);
                if($estado==true){
                    array_push($arrayInsertados, $valor['NroTicket']);
                }
            }
            $primerTicket=$request->data[0]['NroTicket'];
            $codigoTicket= "AT".substr($primerTicket, -4).'N'.$id;
///$codigoTicket="UNIVERSO";
            TblTicketAgrupado::ActualizarTicketAgrupadoJson($id,$codigoTicket);

            ///Código barra
            $imagen_barrahtml=DNS1D::getBarcodePNG($codigoTicket, "C128",1,100);

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $codigoTicket, 'mensaje' => $mensaje_error,'arrayInsertados'=>$arrayInsertados,
                           'codigo_barra_src'=>$imagen_barrahtml,
         ]);        
    }
}
