<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblGeneracionOpcionesSorteo,App\Models\TblCliente,App\Models\TblSorteo,App\Models\TblRestriccione,App\Models\TblConsolidadoOpcionesSorteo,App\Models\TblUbigeo,App\Models\TblTicketAgrupado,App\Models\TblDetalleTicketAgrupado;
use App\Models\Curl;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;



class TicketController extends Controller
{
    public function __construct() 
    { 
        $this->middleware('preventBackHistory');         
    }
    public function SorteoActivoValidarJson($id)
    {
        $respuesta = false;        
        try {
            TblSorteo::SorteoActivar();
            $respuesta=TblSorteo::SorteoActivoValidarJson();  
            $cliente=TblCliente::ObtenerClienteJson(Crypt::decryptString($id)); 
            //dd(session()->get('cliente'));
            if($cliente->verificacionCorreo==1 && session()->get('cliente')==null){
                if($cliente->bloqueado==1)
                {
                    $fechaBloqueo = Carbon::parse($cliente->fechaBloqueo)->addDays(1)->format('Y-m-d G:i:s');                      
                    $fechaActual  = Carbon::now()->format('Y-m-d G:i:s'); 
                    $fechaBloqueo= Carbon::parse($fechaBloqueo);
                    $fechaActual= Carbon::parse($fechaActual); 
                    if( $fechaActual->greaterThanOrEqualTo($fechaBloqueo) ){  
                        tblCliente::DesbloquearClienteJson($cliente->ID);   
                        return view('AllinOneDisabled',[
                            "titulo"=>'',
                            "error"=>'Link Deshabilitado.'
                            ]);                                                                  
                    }
                    else{
                        return view('AllinOneDisabled',[
                            "titulo"=>'Usuario Bloqueado',
                            "error"=>'Su cuenta ha sido bloqueada por superar el límite de intentos de registro de tickets inválidos.
                        Por favor, ingrese nuevamente después de las 24 horas.'
                        ]);
                    } 
                }
                return view('AllinOneDisabled',[
                    "titulo"=>'',
                    "error"=>'Link Deshabilitado.'
                    ]);
            }
            else{
                TblCliente::VerificarCorreClienteJson($cliente->ID);  
                $opciones=TblConsolidadoOpcionesSorteo::ObtenerTotalConsolidadoOpcionesSorteosJson($cliente->ID);              
                if(!$opciones)
                {
                    $opciones = new \stdClass();
                    $opciones->total = 0;
                }  
                if($cliente->bloqueado==1){
                    $fechaBloqueo = Carbon::parse($cliente->fechaBloqueo)->addDays(1)->format('Y-m-d G:i:s');                      
                    $fechaActual  = Carbon::now()->format('Y-m-d G:i:s'); 
                    $fechaBloqueo= Carbon::parse($fechaBloqueo);
                    $fechaActual= Carbon::parse($fechaActual); 
                    if( $fechaActual->greaterThanOrEqualTo($fechaBloqueo) ){  
                        tblCliente::DesbloquearClienteJson($cliente->ID);   
                        return redirect()->route('RegistroT', ['id' => Crypt::encryptString($cliente->ID)]);                                                                   
                    }
                    else{
                        return view('AllinOneDisabled',[
                            "titulo"=>'Usuario Bloqueado',
                            "error"=>'Su cuenta ha sido bloqueada por superar el límite de intentos de registro de tickets inválidos.
                        Por favor, ingrese nuevamente después de las 24 horas.'
                        ]);
                    } 
                }
                else{
                    if($respuesta==1){
                        tblCliente::LimpiarTicketsInvalidosClienteJson($cliente->ID); 
                        tblCliente::LimpiarObservacionesAgrupadasClienteJson($cliente->ID); 
                        return view('AllinOne',["cliente"=>$cliente,"opciones"=>$opciones]);
                    }
                    else{
                        return view('AllinOneDisabled',[
                            "titulo"=>'',
                            "error"=>'Lo sentimos el sorteo aun no se encuentra vigente.'
                            ]);
                    }   
                } 
            }                                                      
        } catch (QueryException $ex) {            
            $mensaje_error = $ex->errorInfo;
        }               
    }     
    public function ConsultarTicketJson(Request $request)
    {
        $mensaje_error="";
        $EstadoTicket=2;
        $stake_amount = 0;
        $strTickets="";
        $puntosGenerados=0;
        $bloqueado=false;
        try {
            $sorteActivo=TblSorteo::ObtenerActivoBeneficioSorteoJson();               
            $restriccion=TblRestriccione::ObtenerRestriccionJson($sorteActivo->id);        
            $ticketBD = TblGeneracionOpcionesSorteo::GeneracionOpcionesSorteoBuscar($request->arrTickets[0]['NroTicket']);
            $ticketAgrupadoBD = TblDetalleTicketAgrupado::ObtenerDetalleTicketAgrupadoJson($request->arrTickets[0]['NroTicket']);
            if (is_null($ticketAgrupadoBD)) {
                if (is_null($ticketBD)) {
                    $client = new Client([
                        'base_uri' => 'http://admin.golden-race.net/qr/ticket_stake?tickets='.$request->arrTickets[0]['NroTicket'],
                        'timeout'  => 20.0,
                    ]);  
                    $response = $client->request('GET');
                    $response=$response->getBody()->getContents();
                    $arrResponseCli=json_decode($response);    
                    if(count($arrResponseCli)==0){
                        $EstadoTicket=6;
                        $cliente=TblCliente::ObtenerClienteJson($request->idCliente);
                        TblCliente::ActualizarTicketClienteJson($request->idCliente,$cliente->ticketsInvalidos+1);
                        if( ($cliente->ticketsInvalidos + 1) >= 3 ){                      
                            TblCliente::BloquearClienteJson($request->idCliente);
                            $bloqueado=true;
                        }
                    }
                    else{
                        $ticket=$arrResponseCli[0];  
                        $stake_amount=$ticket->stake_amount;              
                        $montoPagado= floatval($ticket->stake_amount);
                        $oportunidades= (int)($montoPagado);            
                        $fechaLimite = Carbon::createFromTimestamp($ticket->time_played)->addDays($restriccion->caducidad_ticket)->format('Y-m-d');                      
                        $fechaActual  = Carbon::now()->format('Y-m-d'); 
                        $fechaLimite= Carbon::parse($fechaLimite);
                        $fechaActual= Carbon::parse($fechaActual);  
                        if (strtolower($ticket->ticket_status)!='cancelled') {
                            if (strtolower($ticket->game)!='sn') {
                                if( $montoPagado>=$sorteActivo->valor_apuesta ){
                                    if($fechaLimite->greaterThanOrEqualTo($fechaActual)){
                                        $puntosGenerados=$oportunidades;
                                        $ticket->oportunidades=$oportunidades;
                                        $ticket->idCliente=$request->idCliente;
                                        $ticket->id_sorteo=$sorteActivo->id;
                                        $ticket->local='local';
                                        $ticket->result='result';
                                        $ticket->fecha_registro=date('Y-m-d H:i:s');
                                        $ticket->paid_out_time=date('Y-m-d');
                                        $ticket->id_tienda='1';                                                            
                                        TblGeneracionOpcionesSorteo::GeneracionOpcionSorteoInsertar($ticket);                
                                        $consolidado=TblConsolidadoOpcionesSorteo::ObtenerConsolidadoOpciones($request->idCliente,$sorteActivo->id,$ticket->unit_id, $ticket->game);                                    
                                        $zona=$this->ObtenerZona($ticket->unit_id);
                                        if(is_null($consolidado)){
                                            TblConsolidadoOpcionesSorteo::InsertarConsolidadoOpciones($request->idCliente,$sorteActivo->id,$ticket->unit_id,$ticket->game,$oportunidades,$ticket->stake_amount,$zona);                                      
                                        }
                                        else{
                                            TblConsolidadoOpcionesSorteo::ActualizarConsolidadoOpciones($consolidado->id,$consolidado->cantidad_opciones+$oportunidades,$consolidado->cantidad_tickets+1,$consolidado->stake_amount+$ticket->stake_amount);                    
                                        }
                                        $EstadoTicket=1;
                                    }
                                    else{
                                        $EstadoTicket=5;
                                    }                    
                                }  
                                else{
                                    $EstadoTicket=4;
                                }
                            } else {
                                $EstadoTicket=7;
                            } 
                        } else {
                            $EstadoTicket=8;
                        }                                                                                           
                    }                    
                }   
                else{
                    $EstadoTicket=3;
                    $stake_amount=$ticketBD->stake_amount;
                } 
            } else {
                $EstadoTicket=10;
                $cliente=TblCliente::ObtenerClienteJson($request->idCliente);
                TblCliente::ActualizarTicketClienteJson($request->idCliente,$cliente->ticketsInvalidos+1);
                if( ($cliente->ticketsInvalidos + 1) >= 3 ){                      
                    TblCliente::BloquearClienteJson($request->idCliente);
                    $bloqueado=true;
                }
            }                                                                                                  
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }        
        return response()->json(['stake_amount'=>$stake_amount,'puntosGenerados'=>$puntosGenerados,'EstadoTicket'=>$EstadoTicket,'bloqueado'=>$bloqueado,'mensaje' => $mensaje_error]);   
    }    
    public function ConsultarTicketsJson(Request $request)
    {
        $RespuestaTickets=[];
        $ArrHijos=[];
        $ArrHijosValidados=[];
        $mensaje_error="";
        $EstadoTicket=2;
        $stake_amount = 0;
        $strTickets="";
        $puntosGenerados=0;
        $bloqueado=false;       
        try {
            $sorteActivo=TblSorteo::ObtenerActivoBeneficioSorteoJson();               
            $restriccion=TblRestriccione::ObtenerRestriccionJson($sorteActivo->id);        
            $ticketAgrupadoBD = TblTicketAgrupado::ObtenerTicketAgrupadoJson($request->arrTickets[0]['NroTicket']);
            if (is_null($ticketAgrupadoBD)) {
                //padre no existe               
                $cliente=TblCliente::ObtenerClienteJson($request->idCliente);
                TblCliente::ActualizarTicketClienteJson($request->idCliente,$cliente->ticketsInvalidos+1);
                if( ($cliente->ticketsInvalidos + 1) >= 3 ){                      
                    TblCliente::BloquearClienteJson($request->idCliente);
                    $bloqueado=true;
                }
                $ticketRespuesta = new \stdClass();
                $ticketRespuesta->Mjugado = 0;
                $ticketRespuesta->NroTicket = $request->arrTickets[0]['NroTicket'];
                $ticketRespuesta->oportunidades = 0;
                $ticketRespuesta->valido = 6;
                array_push($RespuestaTickets, $ticketRespuesta);              
            }   
            else{ 
                if ($ticketAgrupadoBD->estado==1) {
                    $ListaHijos = TblDetalleTicketAgrupado::ListarDetalleTicketAgrupadoJson($ticketAgrupadoBD->id);
                    foreach ($ListaHijos as $ticketA){
                        array_push($ArrHijos, $ticketA->id_ticket);
                        $ticketBD = TblGeneracionOpcionesSorteo::GeneracionOpcionesSorteoBuscar($ticketA->id_ticket);
                        if (is_null($ticketBD)) {
                            $strTickets=$strTickets.",".$ticketA->id_ticket;                                     
                        } 
                        else{
                            //ya registrado
                            $ticketRespuesta = new \stdClass();
                            $ticketRespuesta->Mjugado = 0;
                            $ticketRespuesta->NroTicket = $ticketA->id_ticket;
                            $ticketRespuesta->oportunidades = 0;
                            $ticketRespuesta->valido = 3;
                            array_push($RespuestaTickets, $ticketRespuesta);
                            array_push($ArrHijosValidados, $ticketA->id_ticket);
                        }           
                    } 
                    $client = new Client([
                        'base_uri' => 'http://admin.golden-race.net/qr/ticket_stake?tickets='.substr($strTickets, 1),
                        'timeout'  => 20.0,
                    ]);  
                    $response = $client->request('GET');
                    $response=$response->getBody()->getContents();
                    $arrResponseCli=json_decode($response);
                    if(count($arrResponseCli)>0){
                        foreach ($arrResponseCli as $ticket) {
                            array_push($ArrHijosValidados, $ticket->ticket_id);
                            $stake_amount=$ticket->stake_amount;              
                            $montoPagado= floatval($ticket->stake_amount);
                            $oportunidades= (int)($montoPagado);            
                            $fechaLimite = Carbon::createFromTimestamp($ticket->time_played)->addDays($restriccion->caducidad_ticket)->format('Y-m-d');                      
                            $fechaActual = Carbon::now()->format('Y-m-d'); 
                            $fechaLimite= Carbon::parse($fechaLimite);
                            $fechaActual= Carbon::parse($fechaActual);  
                            if (strtolower($ticket->ticket_status)!='cancelled') {
                                if (strtolower($ticket->game)!='sn') {
                                    if( $montoPagado>=$sorteActivo->valor_apuesta ){
                                        if($fechaLimite->greaterThanOrEqualTo($fechaActual)){
                                            $puntosGenerados=$oportunidades;
                                            $ticket->oportunidades=$oportunidades;
                                            $ticket->idCliente=$request->idCliente;
                                            $ticket->id_sorteo=$sorteActivo->id;
                                            $ticket->local='local';
                                            $ticket->result='result';
                                            $ticket->fecha_registro=date('Y-m-d H:i:s');
                                            $ticket->paid_out_time=date('Y-m-d');
                                            $ticket->id_tienda='1';                                                            
                                            TblGeneracionOpcionesSorteo::GeneracionOpcionSorteoInsertar($ticket);                
                                            $consolidado=TblConsolidadoOpcionesSorteo::ObtenerConsolidadoOpciones($request->idCliente,$sorteActivo->id,$ticket->unit_id, $ticket->game);                                    
                                            $zona=$this->ObtenerZona($ticket->unit_id);
                                            if(is_null($consolidado)){
                                                TblConsolidadoOpcionesSorteo::InsertarConsolidadoOpciones($request->idCliente,$sorteActivo->id,$ticket->unit_id,$ticket->game,$oportunidades,$ticket->stake_amount,$zona);                                      
                                            }
                                            else{
                                                TblConsolidadoOpcionesSorteo::ActualizarConsolidadoOpciones($consolidado->id,$consolidado->cantidad_opciones+$oportunidades,$consolidado->cantidad_tickets+1,$consolidado->stake_amount+$ticket->stake_amount);                    
                                            }                                        
                                            $ticketRespuesta = new \stdClass();
                                            $ticketRespuesta->Mjugado = $ticket->stake_amount;
                                            $ticketRespuesta->NroTicket = $ticket->ticket_id;
                                            $ticketRespuesta->oportunidades = $ticket->oportunidades;
                                            $ticketRespuesta->valido = 1;
                                            array_push($RespuestaTickets, $ticketRespuesta);
                                        }
                                        else{                                       
                                            $ticketRespuesta = new \stdClass();
                                            $ticketRespuesta->Mjugado = $ticket->stake_amount;
                                            $ticketRespuesta->NroTicket = $ticket->ticket_id;
                                            $ticketRespuesta->oportunidades = 0;
                                            $ticketRespuesta->valido = 5;
                                            array_push($RespuestaTickets, $ticketRespuesta);
                                        }                    
                                    }  
                                    else{                                   
                                        $ticketRespuesta = new \stdClass();
                                        $ticketRespuesta->Mjugado = $ticket->stake_amount;
                                        $ticketRespuesta->NroTicket = $ticket->ticket_id;
                                        $ticketRespuesta->oportunidades = 0;
                                        $ticketRespuesta->valido = 4;
                                        array_push($RespuestaTickets, $ticketRespuesta);
                                    }
                                } else {                                
                                    $ticketRespuesta = new \stdClass();
                                    $ticketRespuesta->Mjugado = $ticket->stake_amount;
                                    $ticketRespuesta->NroTicket = $ticket->ticket_id;
                                    $ticketRespuesta->oportunidades = 0;
                                    $ticketRespuesta->valido = 7;
                                    array_push($RespuestaTickets, $ticketRespuesta);
                                } 
                            } else {                            
                                $ticketRespuesta = new \stdClass();
                                $ticketRespuesta->Mjugado = $ticket->stake_amount;
                                $ticketRespuesta->NroTicket = $ticket->ticket_id;
                                $ticketRespuesta->oportunidades = 0;
                                $ticketRespuesta->valido = 8;
                                array_push($RespuestaTickets, $ticketRespuesta);
                            } 
                        } 
                        if (count($ListaHijos)>count($ArrHijosValidados)) {
                            $cliente=TblCliente::ObtenerClienteJson($request->idCliente);
                            TblCliente::ActualizarAgrupadosTicketClienteJson($request->idCliente,$cliente->observacion_ticket_agrupado+1);
                            if( ($cliente->observacion_ticket_agrupado + 1) >= 3 ){                      
                                TblCliente::BloquearClienteJson($request->idCliente);
                                $bloqueado=true;
                            }
                            foreach ($ArrHijos as $hijo) {                            
                                if (in_array($hijo, $ArrHijosValidados)==false) {                               
                                    $ticketRespuesta = new \stdClass();
                                    $ticketRespuesta->Mjugado = 0;
                                    $ticketRespuesta->NroTicket = $hijo;
                                    $ticketRespuesta->oportunidades = 0;
                                    $ticketRespuesta->valido = 6;
                                    array_push($RespuestaTickets, $ticketRespuesta);
                                }                            
                            }
                        }                                                                         
                    } 
                    TblTicketAgrupado::InhabilitarTicketAgrupadoJson($ticketAgrupadoBD->id);
                }               
                else {
                    $ticketRespuesta = new \stdClass();
                    $ticketRespuesta->Mjugado = 0;
                    $ticketRespuesta->NroTicket = $request->arrTickets[0]['NroTicket'];
                    $ticketRespuesta->oportunidades = 0;
                    $ticketRespuesta->valido = 9;
                    array_push($RespuestaTickets, $ticketRespuesta);   
                }                                                                                   
            }                                                                           
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }        
        return response()->json(['data' => $RespuestaTickets,'mensaje' => $mensaje_error,'bloqueado'=>$bloqueado]);   
    }    
    public function ObtenerZona($unitId)
    {               
        $zona=0;
        $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
        $curl = New Curl($s3k_password);
        $response=$curl->consultarLocal($unitId);
        $result=$response['result'];
        $departamento=$result["ubigeo_id"];        
        if(strlen($departamento)>2){
            $departamento=substr($departamento, 0, 2);
        }       
        else{
            $departamento=$departamento;
        } 
        $ubigeo=TblUbigeo::ObtenerUbigeoJson((int)$departamento);
        switch ($ubigeo->nombre) {
            case (strtoupper($ubigeo->nombre)=='CAJAMARCA'|| strtoupper($ubigeo->nombre)=='LA LIBERTAD'||
             strtoupper($ubigeo->nombre)=='LAMBAYEQUE'|| strtoupper($ubigeo->nombre)=='PIURA'|| strtoupper($ubigeo->nombre)=='TUMBES'):
                $zona=1;
                break;
            case (strtoupper($ubigeo->nombre)=='AMAZONAS'||strtoupper($ubigeo->nombre)=='LORETO'|| strtoupper($ubigeo->nombre)=='SAN MARTIN'||
            strtoupper($ubigeo->nombre)=='UCAYALI'):
                $zona=2;                
                break;
            case (strtoupper($ubigeo->nombre)=='CALLAO'||strtoupper($ubigeo->nombre)=='HUANUCO'|| strtoupper($ubigeo->nombre)=='JUNIN'||
            strtoupper($ubigeo->nombre)=='LIMA'):
                $zona=3;                            
                break;
            case (strtoupper($ubigeo->nombre)=='AREQUIPA'||strtoupper($ubigeo->nombre)=='AYACUCHO'|| strtoupper($ubigeo->nombre)=='CUSCO'||
            strtoupper($ubigeo->nombre)=='ICA'|| strtoupper($ubigeo->nombre)=='MOQUEGUA'|| strtoupper($ubigeo->nombre)=='PUNO'|| strtoupper($ubigeo->nombre)=='TACNA'):
                $zona=4;                
                break;
        }
        return $zona;   
    }
}
